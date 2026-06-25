<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 12])
                    ->schema([
                        // Left Column (70% - span 8)
                        Group::make([
                            Section::make('Section')
                                ->schema([
                                    TextInput::make('title')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                    TextInput::make('slug')
                                        ->required()
                                        ->unique(ignoreRecord: true, table: 'articles')
                                        ->maxLength(255),
                                ]),

                            Section::make('Article Summary')
                                ->schema([
                                    Textarea::make('summary')
                                        ->label('Ringkasan Artikel')
                                        ->placeholder('Masukkan ringkasan artikel...')
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
                        ])
                        ->columnSpan(['lg' => 8]),

                        // Right Column (30% - span 4)
                        Group::make([
                            Section::make('Preview Artikel Card')
                                ->schema([
                                    Placeholder::make('preview')
                                        ->label('')
                                        ->content(fn ($get) => view('filament.components.article-preview', [
                                            'title' => $get('title'),
                                            'slug' => $get('slug'),
                                            'summary' => $get('summary'),
                                            'content' => $get('content'),
                                            'image' => $get('image'),
                                            'category_id' => $get('category_id'),
                                            'tags' => $get('tags'),
                                            'published_at' => $get('published_at'),
                                        ])),
                                ]),

                            Section::make('Publish')
                                ->schema([
                                    ToggleButtons::make('status')
                                        ->label('Status')
                                        ->options([
                                            'draft' => 'Draft',
                                            'review' => 'Review',
                                            'published' => 'Published',
                                        ])
                                        ->colors([
                                            'draft' => 'gray',
                                            'review' => 'warning',
                                            'published' => 'success',
                                        ])
                                        ->default('draft')
                                        ->live(),

                                    DatePicker::make('published_at')
                                        ->label('Publish Date')
                                        ->default(now()),

                                    Actions::make([
                                        Action::make('save_draft')
                                            ->label('Save Draft')
                                            ->action(fn (Set $set) => $set('status', 'draft'))
                                            ->submit(),
                                        Action::make('publish')
                                            ->label('Publish')
                                            ->color('warning')
                                            ->action(fn (Set $set) => $set('status', 'published'))
                                            ->submit(),
                                    ])->alignEnd(),
                                ]),

                            Section::make('Categorization')
                                ->schema([
                                    Select::make('category_id')
                                        ->relationship('category', 'name')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->live(),

                                    Select::make('tags')
                                        ->multiple()
                                        ->tags()
                                        ->options([
                                            'Laravel' => 'Laravel',
                                            'Filament' => 'Filament',
                                            'PHP' => 'PHP',
                                            'Hukum' => 'Hukum',
                                            'Bisnis' => 'Bisnis',
                                        ])
                                        ->live(),
                                ]),

                            Section::make('Featured Image')
                                ->schema([
                                    FileUpload::make('image')
                                        ->image()
                                        ->directory('articles')
                                        ->imageEditor()
                                        ->live(),
                                ]),

                            Section::make('SEO')
                                ->schema([
                                    TextInput::make('meta_title')
                                        ->live(onBlur: true),
                                    Textarea::make('meta_description')
                                        ->rows(3)
                                        ->live(onBlur: true),
                                    TextInput::make('focus_keyword')
                                        ->live(onBlur: true),
                                    TextInput::make('canonical_url'),

                                    Placeholder::make('seo_indicators')
                                        ->label('')
                                        ->content(fn ($get) => view('filament.components.seo-indicators', [
                                            'score' => self::calculateSeoScore($get),
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
                                            'read_time' => ceil(str_word_count(strip_tags($get('content') ?? '')) / 200),
                                        ])),
                                ]),
                        ])
                        ->columnSpan(['lg' => 4])
                        ->extraAttributes(['class' => 'sticky top-8 space-y-6']),
                    ]),
            ]);
    }

    public static function calculateSeoScore($get): int
    {
        $score = 0;
        $title = $get('title');
        $slug = $get('slug');
        $focusKeyword = $get('focus_keyword');
        $metaTitle = $get('meta_title');
        $metaDescription = $get('meta_description');
        $content = $get('content');

        if (filled($focusKeyword)) {
            $keyword = strtolower($focusKeyword);
            if (filled($title) && str_contains(strtolower($title), $keyword)) {
                $score += 25;
            }
            if (filled($slug) && str_contains(strtolower($slug), $keyword)) {
                $score += 20;
            }
            if (filled($metaDescription) && str_contains(strtolower($metaDescription), $keyword)) {
                $score += 20;
            }
            if (filled($content) && str_contains(strtolower(strip_tags($content)), $keyword)) {
                $score += 15;
            }
        }

        if (filled($metaDescription)) {
            $score += 10;
        }

        if (filled($metaTitle)) {
            $score += 10;
        }

        return min(100, $score);
    }

    public static function calculateReadabilityScore($get): string
    {
        $content = $get('content');
        if (blank($content)) {
            return 'Poor';
        }
        $wordCount = str_word_count(strip_tags($content));
        if ($wordCount > 300) {
            return 'Good';
        } elseif ($wordCount > 100) {
            return 'Ok';
        } else {
            return 'Poor';
        }
    }
}
