<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true, table: 'articles')
                    ->maxLength(255),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                FileUpload::make('image')
                    ->image()
                    ->directory('articles')
                    ->imageEditor()
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Publish')
                    ->default(false)
                    ->live(),

                DateTimePicker::make('published_at')
                    ->label('Published Date')
                    ->default(now())
                    ->required(fn ($get) => $get('is_published')),

                \Filament\Forms\Components\Repeater::make('supporting_images')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('articles/supporting')
                            ->required(),
                        TextInput::make('caption')
                            ->label('Keterangan')
                            ->placeholder('Masukkan keterangan gambar...'),
                    ])
                    ->columnSpanFull()
                    ->reorderable(),
            ]);
    }
}
