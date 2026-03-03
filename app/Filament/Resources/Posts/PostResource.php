<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Post;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;

use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

public static function form(Schema $schema): Schema
{
    return $schema
        ->components([

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
                ->imageEditor(),

            Toggle::make('published')
                ->default(false),

            DateTimePicker::make('published_at')
                ->visible(fn ($get) => $get('published')),
        ]);
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->square(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('published')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }

    public static function infolist(Schema $schema): Schema
{
    return $schema
        ->components([

            TextEntry::make('title'),

            TextEntry::make('slug'),

            TextEntry::make('content')
                ->html()
                ->columnSpanFull(),

            ImageEntry::make('cover_image')
                ->label('Imagem de Capa'),

            IconEntry::make('published')
                ->boolean(),

            TextEntry::make('published_at')
                ->dateTime(),

            TextEntry::make('created_at')
                ->dateTime(),

        ]);
}
}