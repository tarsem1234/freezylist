<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ContractTools;
use App\Http\Controllers\Frontend\CronController;
use App\Http\Controllers\Frontend\FavoriteController;
use App\Http\Controllers\Frontend\ForumController;
use App\Http\Controllers\Frontend\ForumReplyController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\MyDocumentsController;
use App\Http\Controllers\Frontend\NetworkController;
use App\Http\Controllers\Frontend\OfferController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PdfController;
use App\Http\Controllers\Frontend\PropertyController;
use App\Http\Controllers\Frontend\RegisterController;
use App\Http\Controllers\Frontend\SignerController;
use App\Http\Controllers\Frontend\User;
use Illuminate\Support\Facades\Route;

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
//Route::get('test/User/Create', 'TestController@testUserCreate')->name('testUserCreate');
//check back to market cron job mail
Route::get('/checkBackToMarket/{days?}', [CronController::class, 'checkBackToMarket'])->name('testUserCreate');

Route::get('/', [FrontendController::class, 'index'])->name('index');

Route::get('macros', [FrontendController::class, 'macros'])->name('macros');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

Route::get('page/{slug}', [PageController::class, 'getPage'])->name('page.show');

Route::get('sales/home', [PropertyController::class, 'salesHome'])->name('sales-home');
Route::get('rents/home', [PropertyController::class, 'rentsHome'])->name('rents-home');
Route::get('vacations/home', [PropertyController::class, 'vacationsHome'])->name('vacations-home');

// Network Portal
Route::get('support-network', [NetworkController::class, 'supportNetwork'])->name('network.support');
Route::get('social-network', [NetworkController::class, 'socialNetwork'])->name('network.social');

Route::get('social-searched-network', [NetworkController::class, 'searchedSocialNetwork'])->name('searched.socialNetwork');
Route::get('support-searched-network', [NetworkController::class, 'searchedSupportNetwork'])->name('searched.supportnetwork');

Route::get('landing-page', [FrontendController::class, 'landingPage'])->name('landing-page');

// footer pages
Route::get('about-us', [PageController::class, 'aboutUs'])->name('aboutUs');
Route::get('term-of-use-&-limited-liability', [PageController::class, 'termOfUse'])->name('terms');
Route::get('corporate', [PageController::class, 'corporate'])->name('corporate');
Route::get('privacy', [PageController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('e-sign-act-disclosure', [PageController::class, 'eSign'])->name('ESignActDisclosure');
Route::get('help', [PageController::class, 'help'])->name('help');
Route::get('document-portal', [PageController::class, 'documentPortal'])->name('documentPortal');
Route::get('document-portal/{stateId}', [PageController::class, 'documentsList'])->name('documentsList');
Route::get('document-portal/{stateId}/{documentId}', [PageController::class, 'viewDocument'])->name('viewDocument');

// Rent Sale search
//Route::get('property/search-view', 'PropertyController@propertySearch')->name('propertySearch');

Route::get('property/rent-search', [PropertyController::class, 'rentSearch'])->name('rentSearch');
Route::get('property/sale-search', [PropertyController::class, 'saleSearch'])->name('saleSearch');
Route::get('property/searched-sale', [PropertyController::class, 'searchedSale'])->name('searchedSale');
Route::get('property/searched-rent', [PropertyController::class, 'searchedRent'])->name('searchedRent');

//Route::get('property/searched-view',
//    'PropertyController@searchedProperty')->name('searchedProperty');
Route::get('property/details/{id}/{type?}', [PropertyController::class, 'propertyDetails'])->name('propertyDetails');

//Forum
Route::resource('forums', ForumController::class);
Route::get('forum-replies/show/{id}', [ForumController::class, 'forumRepliesShow'])->name('forumReplies.show');

// Vacation search
Route::get('property/vacation/search', [PropertyController::class, 'vacationSearch'])->name('vacationSearch');
Route::get('property/vacation/details/{id}', [PropertyController::class, 'vacationDetails'])->name('vacationDetails');
Route::get('property/vacation/search/view', [PropertyController::class, 'vacationSearching'])->name('vacationSearching');
Route::get('property/city/search', [PropertyController::class, 'citySearch'])->name('citySearch');
Route::get('property/district/search', [PropertyController::class, 'districtAdvanceSearch'])->name('districtAdvanceSearch');

//property ajax
Route::get('property/school/search', [PropertyController::class, 'schoolSearch'])->name('schoolSearch');
Route::get('property/country/search', [PropertyController::class, 'countrySearch'])->name('countrySearch');
Route::get('property/zip/search', [PropertyController::class, 'zipSearch'])->name('zipSearch');
Route::get('property/state/search', [PropertyController::class, 'stateSearch'])->name('stateSearch');
Route::get('property/military-location/search', [PropertyController::class, 'militaryLocationSearch'])->name('militaryLocationSearch');
Route::get('property/state-related-data/search', [PropertyController::class, 'stateRelatedDataSearch'])->name('stateRelatedDataSearch');
Route::get('property/city-county/search', [PropertyController::class, 'cityCountySearch'])->name('cityCountySearch');
Route::get('property/school-district/search', [PropertyController::class, 'schoolDistrict'])->name('schoolDistrict');
Route::get('property/get-counties', [PropertyController::class, 'getCounties'])->name('getCounties');
Route::get('property/get-zipcodes', [PropertyController::class, 'getZipCodes'])->name('getZipCodes');
Route::get('property/get-cities', [PropertyController::class, 'getCities'])->name('getCities');
/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::middleware('auth')->group(function () {
    Route::name('user.')->group(function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', [User\DashboardController::class, 'index'])->name('dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', [User\AccountController::class, 'index'])->name('account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', [User\ProfileController::class, 'update'])->name('profile.update');

        Route::post('blog-comment', [User\CommentController::class, 'storeComment'])->name('storeComment');

        Route::get('forum/loadMore/{count}', [User\ForumController::class, 'loadMoreForums'])->name('forums.loadMore');
    });
    //sent message from property details page
    Route::post('contact-seller-message', [PropertyController::class, 'contactMessage'])->name('contactMessage');

    Route::post('forum/topic/store', [ForumController::class, 'store'])->name('forum.topic.store');
    Route::get('forum/reply/create', [ForumReplyController::class, 'replyCreate'])->name('reply.create');
    Route::post('forumReply', [ForumReplyController::class, 'saveForumReply'])->name('saveForumReply');
    //Change Password
    Route::get('password/edit', [RegisterController::class, 'editPassword'])->name('password.edit');
    Route::post('password/change', [RegisterController::class, 'passwordChange'])->name('password.change');
    //property
    Route::get('rent/create', [PropertyController::class, 'rentCreate'])->name('rentCreate');
    Route::get('rent/edit/{id?}', [PropertyController::class, 'rentCreate'])->name('rentEdit');
    Route::post('rent/store', [PropertyController::class, 'propertyStore'])->name('rentStore');
    Route::post('property/update', [PropertyController::class, 'propertyUpdate'])->name('propertyUpdate');
    Route::get('property/delete/{id}', [PropertyController::class, 'propertyDelete'])->name('propertyDelete');

    Route::get('sale/create', [PropertyController::class, 'saleCreate'])->name('saleCreate');
    Route::get('sale/edit/{id?}', [PropertyController::class, 'saleCreate'])->name('saleEdit');
    Route::post('sale/store', [PropertyController::class, 'propertyStore'])->name('saleStore');
    //property listing
    Route::get('property/rents-list', [PropertyController::class, 'rentsList'])->name('property.rentsList');
    Route::get('property/sales-list', [PropertyController::class, 'salesList'])->name('property.salesList');
    Route::get('property/vacations-list', [PropertyController::class, 'vacationsList'])->name('property.vacationsList');
    Route::post('vacation/update', [PropertyController::class, 'vacationUpdate'])->name('vacationUpdate');
    Route::post('ttt', [PropertyController::class, 'ttt'])->name('ttt');
    Route::get('vacation-property/delete/{id}', [PropertyController::class, 'vacationPropertyDelete'])->name('vacation.vacationPropertyDelete');

    Route::get('vacation/create', [PropertyController::class, 'vacationCreate'])->name('vacationCreate');
    Route::get('vacation/edit/{id?}', [PropertyController::class, 'vacationCreate'])->name('vacationEdit');
    Route::post('vacation/store', [PropertyController::class, 'propertyStore'])->name('vacationStore');

    //    ajax for storing property image
    Route::get('property-image', [PropertyController::class, 'propertyImageStore'])->name('propertyImageStore');

    //Edit Profile
    Route::get('profile/', [RegisterController::class, 'profile'])->name('profile.view');
    Route::get('user/profile/edit/{id}', [RegisterController::class, 'profileEdit'])->name('profile.edit');
    Route::post('user/profile/image', [RegisterController::class, 'profileImage'])->name('profile.image');
    Route::post('user/profile/update', [RegisterController::class, 'profileUpdate'])->name('profileUpdateSave');

    // Property Offers
    Route::get('sale-offer/{id}', [OfferController::class, 'makeSaleOffer'])->name('sale.offer');
    Route::get('rent-offer/{id}', [OfferController::class, 'makeRentOffer'])->name('rent.offer');
    Route::post('make-offer/save', [OfferController::class, 'saveOffer'])->name('make.offer.save');
    Route::get('sent-offers/{type?}', [OfferController::class, 'sentOffers'])->name('sent.offers');
    Route::get('received-offers', [OfferController::class, 'recievedOffers'])->name('recieved.offers');
    Route::get('view-offers', [OfferController::class, 'viewOffers'])->name('view.offers');
    Route::get('view-sent-offer', [OfferController::class, 'viewSentOffer'])->name('sent.view.offer');
    Route::get('view-sent-offer-rent', [OfferController::class, 'viewSentOfferRent'])->name('sent.view.offer.rent');
    Route::get('view-received-offer', [OfferController::class, 'ViewRecievedOffer'])->name('recieved.view.offer');
    Route::get('view-received-offer-rent', [OfferController::class, 'viewRecievedOfferRent'])->name('recieved.view.offer.rent');
    Route::get('accept-offer/{id}/{propertyType}', [OfferController::class, 'acceptOffer'])->name('accept.offer');
    Route::get('reject-offer/{id}/{propertyType}', [OfferController::class, 'rejectOffer'])->name('reject.offer');
    Route::post('counter-offer', [OfferController::class, 'counterOffer'])->name('counter.offer');
    Route::get('counter-offer/accept/{id}/{propertyType}', [OfferController::class, 'acceptCounterOffer'])->name('accept.counterOffer');
    Route::get('counter-offer/reject/{id}/{propertyType}', [OfferController::class, 'rejectCounterOffer'])->name('reject.counterOffer');

    Route::get('accept-rent-offer/{id}', [OfferController::class, 'acceptOffer'])->name('acceptRent.offer');

    Route::get('document-lead-based-paint-hazards', [MyDocumentsController::class, 'documentLeadBasedPaintHazards'])->name('documentLeadBasedPaintHazards');
    Route::get('document-lead-based-paint-hazards-rent', [MyDocumentsController::class, 'documentLeadBasedPaintHazardsRent'])->name('documentLeadBasedPaintHazardsRent');
    Route::middleware('checkOfferValues')->group(function () {
        // my documents
        Route::get('document-disclosure', [MyDocumentsController::class, 'documentDisclosure'])->name('documentDisclosure');
        Route::get('document-sale-agreement', [MyDocumentsController::class, 'documentSaleAgreement'])->name('documentSaleAgreement');
        Route::get('document-advisory-to-buyers-and-sellers', [MyDocumentsController::class, 'documentAdvisoryToBuyersAndSellers'])->name('documentAdvisoryToBuyersAndSellers');
        Route::get('document-Va-Fha-loanAddendum-by-buyer', [MyDocumentsController::class, 'documentVaFhaloanAddendumByBuyer'])->name('documentVaFhaloanAddendumByBuyer');
        Route::get('document-post-closing', [MyDocumentsController::class, 'documentPostClosing'])->name('documentPostClosing');
    });
    Route::get('document-rent-agreement', [MyDocumentsController::class, 'documentRentAgreement'])->name('documentRentAgreement');
    // independent from contract tools
    Route::middleware('checkSignatureValues')->group(function () {
        Route::get('lead-based-paint-hazards/{id?}', [ContractTools\ContractToolSellerController::class, 'leadBasedPaintHazards'])->name('leadBasedPaintHazards');
        Route::get('lead-based-paint-hazards-buyer/{id?}', [ContractTools\ContractToolBuyerController::class, 'leadBasedPaintHazardsBuyer'])->name('leadBasedPaintHazardsBuyer');
    });
    Route::get('disclosure-by-seller-update/{id?}/{page?}', [ContractTools\ContractToolSellerController::class, 'disclosureBySellerUpdate'])->name('disclosureBySellerUpdate');
    //need
    Route::get('lead-based-paint-hazards-rent/{id?}', [ContractTools\ContractToolLandlordController::class, 'leadBasedPaintHazardsRent'])->name('leadBasedPaintHazardsRent');
    Route::post('save-lead-based-paint-hazards/{id?}', [ContractTools\ContractToolSellerController::class, 'saveLeadBasedPaintHazards'])->name('saveLeadBasedPaintHazards');
    Route::post('save-lead-based-paint-hazards-buyer/{id?}', [ContractTools\ContractToolBuyerController::class, 'saveLeadBasedPaintHazardsBuyer'])->name('saveLeadBasedPaintHazardsBuyer');

    Route::post('save-lead-based-paint-hazards-landlord/{id?}', [ContractTools\ContractToolLandlordController::class, 'saveLeadBasedPaintHazardsLandlord'])->name('saveLeadBasedPaintHazardsLandlord');
    Route::post('save-lead-based-paint-hazards-tenant/{id?}', [ContractTools\ContractToolTenantController::class, 'saveLeadBasedPaintHazardsTenant'])->name('saveLeadBasedPaintHazardsTenant');
    Route::middleware('OnlyUsers')->group(function () {
        Route::post('save-seller-property-condition-disclosure/{id?}', [ContractTools\ContractToolSellerController::class, 'saveSellerPropertyConditionDisclosure'])->name('saveSellerPropertyConditionDisclosure');

        // Contract Tools Sale    //Seller
        //check Property session through (middleware)
        Route::middleware('checkPropertyId')->group(function () {

            //Review Offer from Buyer Side
            //sign document
            Route::get('sd-thank-you-seller-for-pd', [ContractTools\ContractToolSellerController::class, 'sdThankYouSellerForPd'])->name('sdThankYouSellerForPd');

            Route::post('save-seller-questionnaire/{id?}', [ContractTools\ContractToolSellerController::class, 'saveSellerQuestionnaire'])->name('saveSellerQuestionnaire');
            Route::middleware('checkSignatureValues')->group(function () {
                Route::get('disclosure-by-buyer-update', [ContractTools\ContractToolBuyerController::class, 'disclosureByBuyerUpdate'])->name('disclosureByBuyerUpdate');

                //need
                Route::get('disclosures-rent-contract-tool-review-tenant', [ContractTools\ContractToolTenantController::class, 'disclosuresRentContractToolReviewTenant'])->name('disclosuresRentContractToolReviewTenant');
                //need
                Route::post('thank-you-for-review-summary-key-terms', [ContractTools\ContractToolTenantController::class, 'thankYouForReviewSummaryKeyTerms'])->name('thankYouForReviewSummaryKeyTerms');
                Route::get('thank-you-to-seller-for-answer', [ContractTools\ContractToolSellerController::class, 'thankYouToSellerForAnswer'])->name('thankYouToSellerForAnswer');
            });
            Route::post('sd-thank-you-for-review-summary-key-terms-tenant', [ContractTools\ContractToolTenantController::class, 'sdThankyouForReviewSummaryKeyTermsTenant'])->name('sdThankyouForReviewSummaryKeyTermsTenant');
        });
        //check Offer session through (middleware)
        Route::middleware('checkOfferValues')->group(function () {
            Route::middleware('checkDeletedUserOffer')->group(function () {
                Route::middleware('checkSignatureValues')->group(function () {
                    Route::get('questions-set-for-seller/{id?}', [ContractTools\ContractToolSellerController::class, 'questionsSetForSeller'])->name('questionsSetForSeller');
                    Route::get('thank-you-lead-based/{value?}', [ContractTools\ContractToolSellerController::class, 'thankYouLeadBased'])->name('thankYouLeadBased');
                    Route::get('seller-property-condition-disclosure', [ContractTools\ContractToolSellerController::class, 'sellerPropertyConditionDisclosure'])->name('sellerPropertyConditionDisclosure');
                    Route::get('thankyou-pd', [ContractTools\ContractToolSellerController::class, 'thankyouPd'])->name('thankyouPd');
                    Route::get('update-sale-agreement-byseller-contract', [ContractTools\ContractToolSellerController::class, 'updateSaleAgreementBysellerContract'])->name('updateSaleAgreementBysellerContract');
                    Route::get('question-set-for-buyer', [ContractTools\ContractToolBuyerController::class, 'questionSetForBuyer'])->name('questionSetForBuyer');
                    Route::get('thank-you-to-buyer-for-answer', [ContractTools\ContractToolBuyerController::class, 'thankYouToBuyerForAnswer'])->name('thankYouToBuyerForAnswer');
                    Route::get('thank-you-accept-offer', [ContractTools\ContractToolBuyerController::class, 'thankYouAcceptOffer'])->name('thankYouAcceptOffer');
                    Route::get('advisory-to-buyers-and-sellers', [ContractTools\ContractToolBuyerController::class, 'advisoryToBuyersAndSellers'])->name('advisoryToBuyersAndSellers');
                    Route::get('advisory-to-buyers-and-sellers-thank-you-buyer', [ContractTools\ContractToolBuyerController::class, 'advisoryToBuyersAndSellersThankYouBuyer'])->name('advisoryToBuyersAndSellersThankYouBuyer');
                    Route::get('thank-you-lead-based-buyer', [ContractTools\ContractToolBuyerController::class, 'thankYouLeadBasedBuyer'])->name('thankYouLeadBasedBuyer');
                    Route::get('thankyou-pd-buyer', [ContractTools\ContractToolBuyerController::class, 'thankyouPdBuyer'])->name('thankyouPdBuyer');
                    Route::get('VA-FHA-loan-addendum-by-buyer', [ContractTools\ContractToolBuyerController::class, 'vaFhaloanAddendumByBuyer'])->name('vaFhaloanAddendumByBuyer');
                    Route::get('va-fha-thank-you-for-buyer', [ContractTools\ContractToolBuyerController::class, 'checkPostClosing'])->name('checkPostClosing');
                    Route::get('update-sale-agreement-by-buyer', [ContractTools\ContractToolBuyerController::class, 'updateSaleAgreementByBuyer'])->name('updateSaleAgreementByBuyer');
                    Route::get('thankyou-purchase-agreement-by-buyer', [ContractTools\ContractToolBuyerController::class, 'thankyouPurchaseAgreementByBuyer'])->name('thankyouPurchaseAgreementByBuyer');
                });

                // when the seller or buyer is business.
                Route::get('business-contract-tools', [ContractTools\ContractToolSellerController::class, 'BusinessContractTools'])->name('BusinessContractTools');

                Route::get('questions-to-seller-property/{value?}', [ContractTools\ContractToolSellerController::class, 'questionsToSellerProperty'])->name('questionsToSellerProperty');
                Route::get('post-closing-questions-thankyou', [ContractTools\ContractToolSellerController::class, 'postClosingQuestionsThankyou'])->name('postClosingQuestionsThankyou');

                Route::get('contract-tools', [ContractTools\ContractToolSellerController::class, 'contractTools'])->name('contractTools');
                Route::get('post-closing-occupancy-agreement', [ContractTools\ContractToolSellerController::class, 'postClosingOccupancyAgreement'])->name('postClosingOccupancyAgreement');

                Route::get('thankyou-purchase-agreement', [ContractTools\ContractToolSellerController::class, 'thankyouPurchaseAgreement'])->name('thankyouPurchaseAgreement');

                Route::post('save-update-sale-agreement-byseller-contract', [ContractTools\ContractToolSellerController::class, 'saveUpdateSaleAgreementBysellerContract'])->name('saveUpdateSaleAgreementBysellerContract');
                Route::post('save-questions-to-seller-post-closing', [ContractTools\ContractToolSellerController::class, 'saveQuestionSellerPostClosing'])->name('saveQuestionSellerPostClosing');
                Route::post('save-questions-to-seller-post-additional_closing', [ContractTools\ContractToolSellerController::class, 'saveQuestionSellerPostAdditionalClosing'])->name('saveQuestionSellerPostAdditionalClosing');

                //Review Offer from Buyer Side
                Route::get('summary-key-terms-for-buyer', [ContractTools\ContractToolBuyerController::class, 'summaryKeyTermsForBuyer'])->name('summaryKeyTermsForBuyer');
                Route::get('purchase-agreement-by-buyer', [ContractTools\ContractToolBuyerController::class, 'purchaseAgreementByBuyer'])->name('purchaseAgreementByBuyer');
                Route::get('va-thank-you-for-buyer', [ContractTools\ContractToolBuyerController::class, 'vaThankYouForBuyer'])->name('vaThankYouForBuyer');
                Route::get('lead-thank-you-for-buyer', [ContractTools\ContractToolBuyerController::class, 'checkVaFhaBuyer'])->name('checkVaFhaBuyer');
                Route::get('post-closing-occupancy-agreement-by-buyer', [ContractTools\ContractToolBuyerController::class, 'postClosingOccupancyAgreementByBuyer'])->name('postClosingOccupancyAgreementByBuyer');
                Route::get('post-closing-thankyou-by-buyer', [ContractTools\ContractToolBuyerController::class, 'postClosingThankyouByBuyer'])->name('postClosingThankyouByBuyer');

                Route::post('store-question-set-for-buyer/{id?}', [ContractTools\ContractToolBuyerController::class, 'storeQuestionSetForBuyer'])->name('storeQuestionSetForBuyer');
                //sign documents buyer
                Route::get('sd-advisory-to-buyers-and-sellers-thank-you-buyer', [ContractTools\ContractToolBuyerController::class, 'sdAdvisoryToBuyersAndSellersThankYouBuyer'])->name('sdAdvisoryToBuyersAndSellersThankYouBuyer');
                Route::get('sd-summary-key-terms-for-buyer', [ContractTools\ContractToolBuyerController::class, 'sdSummaryKeyTermsForBuyer'])->name('sdSummaryKeyTermsForBuyer');
                Route::get('sd-thank-you-buyer-for-pd', [ContractTools\ContractToolBuyerController::class, 'sdThankYouBuyerForPd'])->name('sdThankYouBuyerForPd');
                Route::get('sd-thank-you-buyer-for-pd-va-fha', [ContractTools\ContractToolBuyerController::class, 'sdThankYouBuyerForPd'])->name('sdThankYouBuyerForPd');
                Route::get('sd-advisory-to-buyers-and-sellers', [ContractTools\ContractToolBuyerController::class, 'sdAdvisoryToBuyersAndSellers'])->name('sdAdvisoryToBuyersAndSellers');
                Route::get('sd-thankyou-purchase-agreement-by-buyer', [ContractTools\ContractToolBuyerController::class, 'sdThankyouPurchaseAgreementByBuyer'])->name('sdThankyouPurchaseAgreementByBuyer');
                Route::get('sd-lead-based-paint-hazards-update-by-buyer', [ContractTools\ContractToolBuyerController::class, 'sdLeadBasedPaintHazardsUpdateByBuyer'])->name('sdLeadBasedPaintHazardsUpdateByBuyer');
                Route::get('sd-va-fha-thank-you-buyer', [ContractTools\ContractToolBuyerController::class, 'sdCheckVaFha'])->name('sdCheckVaFha');
                Route::get('sd-VA-FHA-loan-addendum-by-buyer', [ContractTools\ContractToolBuyerController::class, 'sdVaFhaloanAddendumByBuyer'])->name('sdVaFhaloanAddendumByBuyer');
                Route::get('sd-va-fha-thank-you-for-buyer', [ContractTools\ContractToolBuyerController::class, 'sdVaFhaThankYouForBuyer'])->name('sdVaFhaThankYouForBuyer');
                Route::get('sd-post-closing-occupancy-agreement-by-buyer', [ContractTools\ContractToolBuyerController::class, 'sdPostClosingOccupancyAgreementByBuyer'])->name('sdPostClosingOccupancyAgreementByBuyer');
                Route::get('sd-post-closing-thankyou-by-buyer', [ContractTools\ContractToolBuyerController::class, 'sdPostClosingThankyouByBuyer'])->name('sdPostClosingThankyouByBuyer');
                Route::get('sd-post-closing-thankyou-buyer', [ContractTools\ContractToolBuyerController::class, 'sdCheckSignaturePostClosingBuyer'])->name('sdCheckSignaturePostClosingBuyer');
                Route::get('sd-thank-you-buyer-necessary-forms', [ContractTools\ContractToolBuyerController::class, 'sdThankYouBuyerNecessaryForms'])->name('sdThankYouBuyerNecessaryForms');
                Route::get('sd-sale-agreement-review-by-buyer', [ContractTools\ContractToolBuyerController::class, 'sdSaleAgreementReviewByBuyer'])->name('sdSaleAgreementReviewByBuyer');
                Route::get('sd-update-sale-agreement-buyer', [ContractTools\ContractToolBuyerController::class, 'sdUpdateSaleAgreementBuyer'])->name('sdUpdateSaleAgreementBuyer');

                Route::post('advisory-signature', [ContractTools\ContractToolBuyerController::class, 'advisorySignature'])->name('advisorySignature');
                Route::post('disclaimer-signature', [ContractTools\ContractToolBuyerController::class, 'disclaimerSignature'])->name('disclaimerSignature');
                Route::post('sale-agreement-signature', [ContractTools\ContractToolBuyerController::class, 'saleAgreementSignature'])->name('saleAgreementSignature');
                Route::post('lead-based-signature', [ContractTools\ContractToolBuyerController::class, 'leadBasedSignature'])->name('leadBasedSignature');
                Route::post('va-fha-addendum-signature', [ContractTools\ContractToolBuyerController::class, 'vaFhaSignature'])->name('vaFhaSignature');
                Route::post('post-closing-occupancy-agreement-signature', [ContractTools\ContractToolBuyerController::class, 'postClosingSignature'])->name('postClosingSignature');
                Route::post('sale-agreement-signature-seller', [ContractTools\ContractToolBuyerController::class, 'saleAgreementSignatureSeller'])->name('saleAgreementSignatureSeller');

                //sign documents seller
                Route::get('sd-summary-key-terms-for-seller', [ContractTools\ContractToolSellerController::class, 'sdSummaryKeyTermsForSeller'])->name('sdSummaryKeyTermsForSeller');
                Route::get('sd-advisory-to-buyers-and-sellers-sellers', [ContractTools\ContractToolSellerController::class, 'sdAdvisoryToBuyersAndSellersSellers'])->name('sdAdvisoryToBuyersAndSellersSellers');
                Route::get('sd-advisory-to-buyers-and-sellers-thank-you', [ContractTools\ContractToolSellerController::class, 'sdAdvisoryToBuyersAndSellersThankYou'])->name('sdAdvisoryToBuyersAndSellersThankYou');
                Route::get('sd-disclosure-by-seller-update', [ContractTools\ContractToolSellerController::class, 'sdDisclosureBySellerUpdate'])->name('sdDisclosureBySellerUpdate');
                Route::get('sd-lead-based-paint-hazards-update-by-seller', [ContractTools\ContractToolSellerController::class, 'sdLeadBasedPaintHazardsUpdateBySeller'])->name('sdLeadBasedPaintHazardsUpdateBySeller');
                Route::get('sd-thank-you-seller-necessary-forms', [ContractTools\ContractToolSellerController::class, 'sdThankYouSellerNecessaryForms'])->name('sdThankYouSellerNecessaryForms');
                Route::get('sd-va-fha-thank-you-for-seller', [ContractTools\ContractToolSellerController::class, 'sdVaFhaThankYouForSeller'])->name('sdVaFhaThankYouForSeller');
                Route::get('sd-VA-FHA-loan-addendum-by-seller', [ContractTools\ContractToolSellerController::class, 'sdVaFhaloanAddendumBySeller'])->name('sdVaFhaloanAddendumBySeller');
                Route::get('sd-va-fha-thank-you-seller', [ContractTools\ContractToolSellerController::class, 'sdCheckVaFhaSeller'])->name('sdCheckVaFhaSeller');
                Route::get('sd-post-closing-thankyou-seller', [ContractTools\ContractToolSellerController::class, 'sdCheckSignaturePostClosingSeller'])->name('sdCheckSignaturePostClosingSeller');
                Route::get('sd-post-closing-occupancy-agreement-by-seller', [ContractTools\ContractToolSellerController::class, 'sdPostClosingOccupancyAgreementBySeller'])->name('sdPostClosingOccupancyAgreementBySeller');
                Route::get('sd-post-closing-thankyou-by-seller', [ContractTools\ContractToolSellerController::class, 'sdPostClosingThankyouBySeller'])->name('sdPostClosingThankyouBySeller');
                Route::get('sd-sale-agreement-review-by-seller', [ContractTools\ContractToolSellerController::class, 'sdSaleAgreementReviewBySeller'])->name('sdSaleAgreementReviewBySeller');
            });
        });
        Route::get('sign-offers-sale-buyer-partner/{id}', [ContractTools\ContractToolBuyerController::class, 'signOffersSaleBuyerPartner'])->name('signOffersSaleBuyerPartner');
        Route::get('sign-offers-sale-seller-partner/{id}', [ContractTools\ContractToolSellerController::class, 'signOffersSaleSellerPartner'])->name('signOffersSaleSellerPartner');

        Route::get('sign-offers-rent-tenant-partner/{id}', [ContractTools\ContractToolTenantController::class, 'signOffersRentTenantPartner'])->name('signOffersRentTenantPartner');
        Route::get('sign-offers-rent-landlord-partner/{id}', [ContractTools\ContractToolLandlordController::class, 'signOffersRentLandlordPartner'])->name('signOffersRentLandlordPartner');

        //sign documents buyer (use both offer and property_id)
        Route::get('sd-disclosure-by-buyer-update', [ContractTools\ContractToolBuyerController::class, 'sdDisclosureByBuyerUpdate'])->name('sdDisclosureByBuyerUpdate');

        //sign documents seller
        Route::get('sd-update-sale-agreement', [ContractTools\ContractToolSellerController::class, 'sdUpdateSaleAgreement'])->name('sdUpdateSaleAgreement');
        Route::get('sd-thankyou-purchase-agreement', [ContractTools\ContractToolSellerController::class, 'sdThankyouPurchaseAgreement'])->name('sdThankyouPurchaseAgreement');
        //    Route::get('va-fha-thank-you-for-buyer', 'ContractToolBuyerController@vaFhaThankYouForBuyer')->name('vaFhaThankYouForBuyer');

        Route::post('save-landlord-property-condition-disclosure/{id?}', [ContractTools\ContractToolSellerController::class, 'saveSellerPropertyConditionDisclosure'])->name('saveLandlordPropertyConditionDisclosure');

        Route::middleware('checkOfferValues')->group(function () {
            Route::middleware('checkDeletedUserOffer')->group(function () {
                // Rent Contract tool landlord
                Route::get('contract-tools-rent', [ContractTools\ContractToolLandlordController::class, 'contractToolsRent'])->name('contractToolsRent');
                //check Offer session through (middleware)
                Route::middleware('checkSignatureValues')->group(function () {
                    //need
                    Route::get('questions-to-landlord', [ContractTools\ContractToolLandlordController::class, 'questionsToLandlord'])->name('questionsToLandlord');
                    Route::get('add-signers-contract-rent-landlord', [ContractTools\ContractToolLandlordController::class, 'addSignersContractRentLandlord'])->name('addSignersContractRentLandlord');
                    //need
                    Route::get('thankyou-discloser-tool', [ContractTools\ContractToolLandlordController::class, 'thankyouDiscloserTool'])->name('thankyouDiscloserTool');
                    //need
                    Route::get('thankyou-lease-agreement-landlord', [ContractTools\ContractToolLandlordController::class, 'thankyouLeaseAgreementLandlord'])->name('thankyouLeaseAgreementLandlord');
                    //need
                    Route::get('lease-agreement', [ContractTools\ContractToolLandlordController::class, 'leaseAgreement'])->name('leaseAgreement');
                    //need
                    Route::get('thank-you-to-landlord-for-answer', [ContractTools\ContractToolLandlordController::class, 'thankYouToLandlordForAnswer'])->name('thankYouToLandlordForAnswer');
                    //need
                    Route::get('disclosures-rent-contract-tool', [ContractTools\ContractToolLandlordController::class, 'disclosuresRentContractTool'])->name('disclosuresRentContractTool');

                    //need
                    Route::get('question-set-for-tenant', [ContractTools\ContractToolTenantController::class, 'questionSetForTenant'])->name('questionSetForTenant');
                    //need
                    Route::get('lease-agreement-review-tenant', [ContractTools\ContractToolTenantController::class, 'leaseAgreementReviewTenant'])->name('leaseAgreementReviewTenant');
                    //need
                    Route::get('thank-you-lead-based-disclosure-for-rent-tenant', [ContractTools\ContractToolTenantController::class, 'thankYouLeadBasedDisclosureForRentTenant'])->name('thankYouLeadBasedDisclosureForRentTenant');
                    //need
                    Route::get('thankyou-discloser-tool-tenant', [ContractTools\ContractToolTenantController::class, 'thankyouDiscloserToolTenant'])->name('thankyouDiscloserToolTenant');
                    //need
                    Route::get('add-signers-contract-rent-tenant', [ContractTools\ContractToolTenantController::class, 'addSignersContractRentTenant'])->name('addSignersContractRentTenant');
                    //need
                    Route::get('thankyou-lease-agreement-tenant', [ContractTools\ContractToolTenantController::class, 'thankyouLeaseAgreementTenant'])->name('thankyouLeaseAgreementTenant');
                });

                Route::get('sd-summary-key-terms-for-landlord', [ContractTools\ContractToolLandlordController::class, 'sdSummaryKeyTermsForLandlord'])->name('sdSummaryKeyTermsForLandlord');
                Route::post('save-lease-agreement', [ContractTools\ContractToolLandlordController::class, 'saveLeaseAgreement'])->name('saveLeaseAgreement');
                Route::post('save-questions-to-landlord/{id?}', [ContractTools\ContractToolLandlordController::class, 'saveQuestionsToLandlord'])->name('saveQuestionsToLandlord');
                //Sign documents landlord
                Route::post('sd-thank-you-for-review-summary-key-terms-landlord', [ContractTools\ContractToolLandlordController::class, 'sdThankyouForReviewSummaryKeyTermsLandlord'])->name('sdThankyouForReviewSummaryKeyTermsLandlord');
                Route::get('sd-thank-you-landlord-for-pd', [ContractTools\ContractToolLandlordController::class, 'sdThankYouLandlordForPd'])->name('sdThankYouLandlordForPd');
                Route::get('sd-lease-agreement-by-landlord', [ContractTools\ContractToolLandlordController::class, 'sdLeaseAgreementByLandlord'])->name('sdLeaseAgreementByLandlord');
                Route::get('sd-thankyou-lease-agreement-landlord', [ContractTools\ContractToolLandlordController::class, 'sdThankyouLeaseAgreementLandlord'])->name('sdThankyouLeaseAgreementLandlord');
                Route::get('sd-lead-based-paint-hazards-disclosure-for-rent-by-landlord', [ContractTools\ContractToolLandlordController::class, 'sdLeadBasedPaintHazardsDisclosureForRentByLandlord'])->name('sdLeadBasedPaintHazardsDisclosureForRentByLandlord');
                Route::get('sd-thank-you-landlord-necessary-forms', [ContractTools\ContractToolLandlordController::class, 'sdThankYouLandlordNecessaryForms'])->name('sdThankYouLandlordNecessaryForms');

                Route::post('save-add-signers-contract-rent-tenant/{id?}', [ContractTools\ContractToolTenantController::class, 'saveAddSignersContractRentTenant'])->name('saveAddSignersContractRentTenant');

                Route::get('thankyou-for-rent-offer', [ContractTools\ContractToolTenantController::class, 'thankyouForRentOffer'])->name('thankyouForRentOffer');

                Route::get('summary-key-terms-for-tenant', [ContractTools\ContractToolTenantController::class, 'summaryKeyTermsForTenant'])->name('summaryKeyTermsForTenant');

                //Sign documents tenant
                Route::get('sd-thank-you-tenant-for-pd', [ContractTools\ContractToolTenantController::class, 'sdThankYouTenantForPd'])->name('sdThankYouTenantForPd');
                Route::get('sd-lease-agreement-by-tenant', [ContractTools\ContractToolTenantController::class, 'sdLeaseAgreementByTenant'])->name('sdLeaseAgreementByTenant');
                Route::get('sd-thankyou-lease-agreement-tenant', [ContractTools\ContractToolTenantController::class, 'sdThankyouLeaseAgreementTenant'])->name('sdThankyouLeaseAgreementTenant');
                Route::get('sd-lead-based-paint-hazards-disclosure-for-rent-by-tenant', [ContractTools\ContractToolTenantController::class, 'sdLeadBasedPaintHazardsDisclosureForRentByTenant'])->name('sdLeadBasedPaintHazardsDisclosureForRentByTenant');
                Route::get('sd-thank-you-tenant-necessary-forms', [ContractTools\ContractToolTenantController::class, 'sdThankYouTenantNecessaryForms'])->name('sdThankYouTenantNecessaryForms');

                //rent signature
                Route::post('disclaimer-signature-rent', [ContractTools\ContractToolTenantController::class, 'disclaimerSignatureRent'])->name('disclaimerSignatureRent');
                Route::post('sale-agreement-signature-rent', [ContractTools\ContractToolTenantController::class, 'saleAgreementSignatureRent'])->name('saleAgreementSignatureRent');
                Route::post('lead-based-signature-rent', [ContractTools\ContractToolTenantController::class, 'leadBasedSignatureRent'])->name('leadBasedSignatureRent');
                Route::get('sd-summary-key-terms-for-tenant', [ContractTools\ContractToolTenantController::class, 'sdSummaryKeyTermsForTenant'])->name('sdSummaryKeyTermsForTenant');

                Route::get('sd-disclosures-rent-tenant', [ContractTools\ContractToolTenantController::class, 'sdDisclosuresRentTenant'])->name('sdDisclosuresRentTenant');
                Route::get('sd-disclosures-rent-landlord', [ContractTools\ContractToolLandlordController::class, 'sdDisclosuresRentLandlord'])->name('sdDisclosuresRentLandlord');
            });
        });
    });
    Route::post('contract-tool-signers', [SignerController::class, 'contractToolSigner'])->name('contractToolSigner');

    Route::get('sale-agreement-signature-Pdf/', [PdfController::class, 'saleAgreementSignPdf'])->name('saleAgreementSignPdf');
    Route::get('Va-Fha-signature-Pdf', [PdfController::class, 'VaFhsSignPdf'])->name('VaFhsSignPdf');
    Route::get('post-closing-signature-Pdf', [PdfController::class, 'postClosingSignPdf'])->name('postClosingSignPdf');
    Route::get('advisory-signature-Pdf', [PdfController::class, 'advisorySignPdf'])->name('advisorySignPdf');
    Route::get('lead-based-signature-Pdf', [PdfController::class, 'leadBasedSignPdf'])->name('leadBasedSignPdf');
    Route::get('property-disclaimer-signature-Pdf', [PdfController::class, 'propertyDisclaimerSignPdf'])->name('propertyDisclaimerSignPdf');

    Route::get('rent-agreement-signature-Pdf/', [PdfController::class, 'rentAgreementSignPdf'])->name('rentAgreementSignPdf');
    Route::get('lead-based-rent-signature-Pdf', [PdfController::class, 'leadBasedRentSignPdf'])->name('leadBasedRentSignPdf');
    Route::get('property-disclaimer-rent-signature-Pdf', [PdfController::class, 'propertyDisclaimerRentSignPdf'])->name('propertyDisclaimerRentSignPdf');
    //Network searched user details show
    Route::get('network/user-details/{id}', [NetworkController::class, 'userDetails'])->name('network.userDetails');
    Route::get('network/request-sent/{id}', [NetworkController::class, 'requestSent'])->name('request.sent');
    Route::get('network/received-requests', [NetworkController::class, 'receivedRequests'])->name('received.requests');
    Route::get('network/sent-requests', [NetworkController::class, 'sentRequests'])->name('sent.requests');
    Route::get('network/accept-request/{id}', [NetworkController::class, 'acceptRequest'])->name('accept.request');
    Route::get('network/reject-request/{id}', [NetworkController::class, 'rejectRequest'])->name('reject.request');
    Route::get('network/cancel-request/{id}', [NetworkController::class, 'cancelRequest'])->name('cancel.request');
    Route::get('my-network', [NetworkController::class, 'myNetwork'])->name('myNetwork');
    Route::get('network/delete-connection/{id}', [NetworkController::class, 'deleteConnection'])->name('delete.connection');
    Route::get('network/profile-rating', [NetworkController::class, 'profileRating'])->name('profile.rating');

    Route::middleware('OnlyUsers')->group(function () {
        //Signers
        Route::get('signers', [SignerController::class, 'index'])->name('signer.index');
        Route::get('signer/create', [SignerController::class, 'create'])->name('signer.create');
        Route::post('signer/store', [SignerController::class, 'signStore'])->name('signer.store');
        Route::get('signer/resend-activation/{id}', [SignerController::class, 'resendActivation'])->name('resend.activation');
        Route::get('signer/delete/{id}', [SignerController::class, 'deleteSigner'])->name('delete.signer');
        Route::get('signer/view/{id}', [SignerController::class, 'signerView'])->name('signer.view');

        //My documents
        Route::get('received-documents', [MyDocumentsController::class, 'receivedDocuments'])->name('receivedDocuments');
        Route::get('sent-documents', [MyDocumentsController::class, 'sentDocuments'])->name('sentDocuments');
        Route::get('received-document-details-rent', [MyDocumentsController::class, 'receivedDocumentDetailsRent'])->name('receivedDocumentDetailsRent');
        Route::get('received-document-details-sale', [MyDocumentsController::class, 'receivedDocumentDetailsSale'])->name('receivedDocumentDetailsSale');
        Route::get('sent-document-details-rent', [MyDocumentsController::class, 'sentDocumentDetailsRent'])->name('sentDocumentDetailsRent');
        Route::get('sent-document-details-sale', [MyDocumentsController::class, 'sentDocumentDetailsSale'])->name('sentDocumentDetailsSale');
        Route::get('sent-documents-details', [MyDocumentsController::class, 'sentDocumentDetails'])->name('sentDocumentDetails');
        Route::get('download-documents-rent', [MyDocumentsController::class, 'downloadDocumentsRent'])->name('downloadDocumentsRent');
        Route::get('download-documents-sale', [MyDocumentsController::class, 'downloadDocumentsSale'])->name('downloadDocumentsSale');

        //Favorites
        Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites');
        Route::get('favorite/store/{id}', [FavoriteController::class, 'favoriteStore'])->name('favorite.store');
        Route::get('favorite/delete/{id}', [FavoriteController::class, 'favoriteDelete'])->name('favorite.delete');

        // sign documents for partners or co-signers
        Route::get('partners-sign-documents', [ContractTools\SignDocumentsController::class, 'partnersSignDocuments'])->name('partnersSignDocuments');
        Route::get('sign-documents-buyer', [ContractTools\SignDocumentsController::class, 'signDocumentsBuyer'])->name('signDocumentsBuyer');
        Route::get('sign-documents-seller', [ContractTools\SignDocumentsController::class, 'signDocumentsSeller'])->name('signDocumentsSeller');
        Route::get('sign-documents-landlord', [ContractTools\SignDocumentsController::class, 'signDocumentsLandlord'])->name('signDocumentsLandlord');
        Route::get('sign-documents-tenant', [ContractTools\SignDocumentsController::class, 'signDocumentsTenant'])->name('signDocumentsTenant');
    });
    Route::get('back-to-market/{id}', [PropertyController::class, 'backToMarket'])->name('backToMarket');
    Route::get('change-property-status/{id}', [PropertyController::class, 'changePropertyStatus'])->name('changePropertyStatus');
    require_once __DIR__.'/other.php';
});

Route::get('signer/account-confirm/{token}', [SignerController::class, 'accountConfirm'])->name('account.confirm');
