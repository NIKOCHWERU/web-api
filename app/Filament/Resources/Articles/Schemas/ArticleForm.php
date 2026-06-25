<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Actions\Action;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 12])
                    ->schema([

                        // ── Left Column (70% – span 8) ──────────────────
                        Group::make([

                            Section::make('Section')
                                ->schema([
                                    TextInput::make('title')
                                        ->label('Title Input')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                    TextInput::make('slug')
                                        ->label('Automatically generated Slug')
                                        ->required()
                                        ->unique(ignoreRecord: true, table: 'articles')
                                        ->maxLength(255)
                                        ->prefix('slug:'),
                                ]),

                            Section::make('Article Summary')
                                ->schema([
                                    Textarea::make('summary')
                                        ->label('Ringkasan Artikel')
                                        ->placeholder('Masukkan ringkasan singkat artikel...')
                                        ->rows(4)
                                        ->live(onBlur: true),
                                ]),

                            Section::make('Rich Editor')
                                ->schema([
                                    RichEditor::make('content')
                                        ->required()
                                        ->toolbarButtons([
                                            'attachFiles',
                                            'blockquote',
                                            'bold',
                                            'bulletList',
                                            'codeBlock',
                                            'h1',
                                            'h2',
                                            'h3',
                                            'italic',
                                            'link',
                                            'orderedList',
                                            'redo',
                                            'strike',
                                            'underline',
                                            'undo',
                                        ])
                                        ->fileAttachmentsDirectory('articles/content')
                                        ->fileAttachmentsVisibility('public')
                                        ->live(onBlur: true),
                                ]),

                            Section::make('Published Articles')
                                ->schema([
                                    Placeholder::make('recent_articles')
                                        ->label('')
                                        ->content(fn () => view('filament.components.recent-articles-table')),
                                ]),

                        ])->columnSpan(['lg' => 8]),

                        // ── Right Column (30% – span 4, sticky) ─────────
                        Group::make([

                            Section::make('Preview Artikel Card')
                                ->schema([
                                    Placeholder::make('preview_card')
                                        ->label('')
                                        ->content(fn ($get) => view('filament.components.article-preview', [
                                            'title'        => $get('title'),
                                            'slug'         => $get('slug'),
                                            'summary'      => $get('summary'),
                                            'content'      => $get('content'),
                                            'image'        => $get('image'),
                                            'category_id'  => $get('category_id'),
                                            'tags'         => $get('tags'),
                                            'published_at' => $get('published_at'),
                                        ])),
                                ]),

                            Section::make('Publish')
                                ->schema([
                                    ToggleButtons::make('status')
                                        ->label('Status')
                                        ->options([
                                            'draft'     => 'Draft',
                                            'review'    => 'Review',
                                            'published' => 'Published',
                                        ])
                                        ->colors([
                                            'draft'     => 'gray',
                                            'review'    => 'warning',
                                            'published' => 'success',
                                        ])
                                        ->default('draft')
                                        ->grouped()
                                        ->live(),

                                    DatePicker::make('published_at')
                                        ->label('Publish Date')
                                        ->default(now()),

                                    Actions::make([
                                        Action::make('save_draft')
                                            ->label('Save Draft')
                                            ->color('gray')
                                            ->action(fn (Set $set) => $set('status', 'draft'))
                                            ->submit('save'),

                                        Action::make('publish_now')
                                            ->label('Publish')
                                            ->color('warning')
                                            ->action(fn (Set $set) => $set('status', 'published'))
                                            ->submit('save'),
                                    ])->fullWidth(),
                                ]),

                            Section::make('Categorization')
                                ->schema([
                                    Select::make('category_id')
                                        ->label('Select Category')
                                        ->relationship('category', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->live(),

                                    Select::make('tags')
                                        ->label('Tags')
                                        ->multiple()
                                        ->tags()
                                        ->options([
                                            'Laravel'  => 'Laravel',
                                            'Filament' => 'Filament',
                                            'PHP'      => 'PHP',
                                            'Hukum'    => 'Hukum',
                                            'Bisnis'   => 'Bisnis',
                                            'Edukasi'  => 'Edukasi',
                                            'UMKM'     => 'UMKM',
                                        ])
                                        ->live(),
                                ]),

                            Section::make('Featured Image')
                                ->schema([
                                    FileUpload::make('image')
                                        ->label('FileUpload with Drag & Drop')
                                        ->image()
                                        ->directory('articles')
                                        ->imageEditor()
                                        ->live(),
                                ]),

                            Section::make('SEO')
                                ->schema([
                                    TextInput::make('meta_title')
                                        ->label('Meta Title')
                                        ->live(onBlur: true),

                                    Textarea::make('meta_description')
                                        ->label('Meta Description')
                                        ->rows(3)
                                        ->live(onBlur: true),

                                    TextInput::make('focus_keyword')
                                        ->label('Focus Keyword')
                                        ->live(onBlur: true),

                                    TextInput::make('canonical_url')
                                        ->label('Canonical URL'),

                                    Placeholder::make('seo_indicators')
                                        ->label('')
                                        ->content(fn ($get) => view('filament.components.seo-indicators', [
                                            'score'       => self::calculateSeoScore($get),
                                            'readability' => self::calculateReadabilityScore($get),
                                        ])),
                                ]),

                            Section::make('Widgets')
                                ->schema([
                                    Placeholder::make('article_stats')
                                        ->label('')
                                        ->content(fn ($get) => view('filament.components.article-stats', [
                                            'word_count' => str_word_count(strip_tags($get('content') ?? '')),
                                            'char_count' => mb_strlen(strip_tags($get('content') ?? '')),
                                            'read_time'  => max(1, ceil(str_word_count(strip_tags($get('content') ?? '')) / 200)),
                                        ])),
                                ]),

                        ])->columnSpan(['lg' => 4]),

                    ]),
            ]);
    }

    /**
     * Calculate SEO score (0–100) based on keyword presence across key fields.
     */
    public static function calculateSeoScore($get): int
    {
        $score   = 0;
        $keyword = strtolower(trim($get('focus_keyword') ?? ''));

        if (filled($keyword)) {
            if (filled($get('title')) && str_contains(strtolower($get('title')), $keyword)) {
                $score += 25;
            }
            if (filled($get('slug')) && str_contains(strtolower($get('slug')), $keyword)) {
                $score += 20;
            }
            if (filled($get('meta_description')) && str_contains(strtolower($get('meta_description')), $keyword)) {
                $score += 20;
            }
            if (filled($get('content')) && str_contains(strtolower(strip_tags($get('content'))), $keyword)) {
                $score += 15;
            }
        }

        if (filled($get('meta_description'))) $score += 10;
        if (filled($get('meta_title')))       $score += 10;

        return min(100, $score);
    }

    /**
     * Calculate readability based on word count.
     */
    public static function calculateReadabilityScore($get): string
    {
        $words = str_word_count(strip_tags($get('content') ?? ''));
        if ($words > 300) return 'Good';
        if ($words > 100) return 'Ok';
        return 'Poor';
    }
}
