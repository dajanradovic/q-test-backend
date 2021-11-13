<?php

namespace App\Services\Interfaces;


interface AnalyticsServiceInterface{

      public static function getLabel(): string;

      public function getMonthlyReportData(): array;

}