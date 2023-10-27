<?php

namespace App\Filament\Resources;


use App\Enum\ProductTypeEnum;
use App\Enums\ProductTypeEnums;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Store';

    protected static ?string $navigationLabel = "Products";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make(name: 'name'),
                        Forms\Components\TextInput::make(name: 'slug'),
                        Forms\Components\MarkdownEditor::make(name: 'description')
                            ->columnSpan(span: 'full')
                    ])->columns(columns: 2),

                    Forms\Components\Section::make(heading:'Pricing and Inventory')
                    ->schema([
                        Forms\Components\TextInput::make(name: 'sku'),
                        Forms\Components\TextInput::make(name: 'price'),
                        Forms\Components\TextInput::make(name: 'quantity'),
                        Forms\Components\Select::make(name: 'type')
                        ->options([
                            'downloadable' => ProductTypeEnum::DOWNLOADBLE->value,
                            'deliverable' => ProductTypeEnum::DELIVERABLE->value,
                            ])

                    ])->columns(columns: 2),
                ]),


                
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make(heading: 'Status')
                    ->schema([
                     Forms\Components\Toggle::make('is_visible'),
                     Forms\Components\Toggle::make('is_featured'),
                     Forms\Components\DatePicker::make('published_at'),
                    ]),

                     Forms\Components\Section::make(heading: 'Image')
                    
                     ->schema([
                        Forms\Components\FileUpload::make(name: 'image')
                     ])->collapsible(),
                    

                    // Another components
                    Forms\Components\Section::make(heading: 'Associations')
                    
                    ->schema([
                        Forms\Components\Select::make(name: 'brand_id')
                        ->relationship(name: 'brands', titleAttribute: 'name')
                        ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make(name: 'image'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make(name: 'brand.name'),
                Tables\Columns\IconColumn::make(name: 'is_visible')->boolean(),
                Tables\Columns\TextColumn::make(name: 'price'),
                Tables\Columns\TextColumn::make(name: 'quantity'),
                Tables\Columns\TextColumn::make(name: 'published_at'),
                Tables\Columns\TextColumn::make(name: 'type')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
