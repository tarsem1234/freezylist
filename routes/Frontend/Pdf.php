<?php

use App\Http\Controllers\Frontend\PdfController;
use Illuminate\Support\Facades\Route;

//generate pdf's
Route::get('lead-based-paint-hazards-pdf/{id}', [PdfController::class, 'leadBasedPaintHazardsPdf'])->name('leadBasedPaintHazardsPdf');
Route::get('property-condition-disclaimerPdf-pdf/{id}', [PdfController::class, 'propertyDisclaimerPdf'])->name('propertyDisclaimerPdf');
