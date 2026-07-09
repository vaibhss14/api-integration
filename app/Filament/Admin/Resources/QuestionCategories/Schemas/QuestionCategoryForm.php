<?php

namespace App\Filament\Admin\Resources\QuestionCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuestionCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category_id')
                    ->label('Category ID')
                    ->numeric()
                    ->required(),

                TextInput::make('category_name')
                    ->label('Category Name')
                    ->required(),
            ]);
    }
}
