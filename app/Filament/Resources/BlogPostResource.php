<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Blog Posts';
    
    protected static ?string $navigationGroup = 'Blog';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Blog Post';
    
    protected static ?string $pluralModelLabel = 'Blog Posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        // Main Content Section
                        Forms\Components\Section::make('Konten')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => 
                                        $set('slug', Str::slug($state))),
                                
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                
                                Forms\Components\Textarea::make('excerpt')
                                    ->label('Ringkasan')
                                    ->rows(3)
                                    ->helperText('Akan tampil di preview list blog'),
                                
                                Forms\Components\RichEditor::make('content')
                                    ->label('Isi Artikel')
                                    ->required()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('blog-attachments'),
                            ])
                            ->columns(2),
                        
                        // SEO Section
                        Forms\Components\Section::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(60)
                                    ->helperText('Maksimal 60 karakter. Kosongkan untuk pakai judul.'),
                                
                                Forms\Components\Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(2)
                                    ->maxLength(160)
                                    ->helperText('Maksimal 160 karakter. Kosongkan untuk pakai excerpt.'),
                                
                                Forms\Components\TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->helperText('Pisahkan dengan koma'),
                            ])
                            ->collapsed(),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                // Sidebar
                Forms\Components\Group::make()
                    ->schema([
                        // Publishing Section
                        Forms\Components\Section::make('Publishing')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'scheduled' => 'Scheduled',
                                        'published' => 'Published',
                                    ])
                                    ->default('draft')
                                    ->native(false)
                                    ->reactive(),
                                
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Tanggal Publish')
                                    ->native(false)
                                    ->visible(fn ($get) => in_array($get('status'), ['scheduled', 'published'])),
                                
                                Forms\Components\Select::make('user_id')
                                    ->label('Author')
                                    ->relationship('author', 'name')
                                    ->default(auth()->id())
                                    ->required()
                                    ->native(false),
                            ]),
                        
                        // Category & Tags Section
                        Forms\Components\Section::make('Kategori & Tags')
                            ->schema([
                                Forms\Components\Select::make('blog_category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\TextInput::make('slug')
                                            ->required(),
                                    ])
                                    ->native(false),
                                
                                Forms\Components\Select::make('tags')
                                    ->label('Tags')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\TextInput::make('slug')
                                            ->required(),
                                    ]),
                            ]),
                        
                        // Featured Image Section
                        Forms\Components\Section::make('Gambar')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('Featured Image')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('675')
                                    ->directory('blog-images'),
                                
                                Forms\Components\TextInput::make('featured_image_alt')
                                    ->label('Alt Text')
                                    ->maxLength(255),
                            ]),
                        
                        // Options Section
                        Forms\Components\Section::make('Opsi')
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Tampilkan di Homepage'),
                                
                                Forms\Components\Toggle::make('allow_comments')
                                    ->label('Izinkan Komentar')
                                    ->default(true),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Gambar')
                    ->square(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40)
                    ->description(fn (BlogPost $record): string => 
                        $record->category?->name ?? 'Tanpa Kategori'),
                
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'scheduled' => 'warning',
                        'draft' => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Publish')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('view_count')
                    ->label('Views')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Scheduled',
                        'published' => 'Published',
                    ]),
                Tables\Filters\SelectFilter::make('blog_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
