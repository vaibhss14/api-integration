<?php

namespace App\Filament\Admin\Resources\SurveyQuotas;

use App\Filament\Admin\Resources\SurveyQuotas\Pages\EditSurveyQuota;
use App\Filament\Admin\Resources\SurveyQuotas\Pages\ListSurveyQuotas;
use App\Filament\Admin\Resources\SurveyQuotas\Schemas\SurveyQuotaForm;
use App\Filament\Admin\Resources\SurveyQuotas\Tables\SurveyQuotasTable;
use App\Models\SurveyQuota;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SurveyQuotaResource extends Resource
{
    protected static ?string $model = SurveyQuota::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'quota_name';

    protected static ?int $navigationSort = 16;

    public static function form(Schema $schema): Schema
    {
        return SurveyQuotaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurveyQuotasTable::configure($table);
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
            'index' => ListSurveyQuotas::route('/'),
            'edit' => EditSurveyQuota::route('/{record}/edit'),
        ];
    }
}
