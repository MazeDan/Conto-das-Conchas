<?php

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Support\Str;
class PostForm
{
public static function form(Form $form): Form
{
    return $form
        ->schema([

            TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) =>
                    $set('slug', Str::slug($state))
                ),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            RichEditor::make('content')
                ->required()
                ->columnSpanFull(),

            FileUpload::make('cover_image')
                ->image()
                ->directory('posts')
                ->imageEditor()
                ->visibility('public'),

            Toggle::make('published')
                ->default(false),

            DateTimePicker::make('published_at')
                ->visible(fn ($get) => $get('published')),
        ]);
}

protected static function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = auth()->id();
    return $data;
}
}

