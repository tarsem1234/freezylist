<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">   
    <title>PURCHASE AND SALE AGREEMENT</title>
    <style>  
        body {
            font-family: 'Poppins', sans-serif;
            color: #222222;
            margin: 2cm;
        } 
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none  ! important; 
            -moz-appearance: none  ! important; 
            appearance: none  ! important; 
        } 
        .pull-right-div > input[type=checkbox] + label{
            display: inline-block; 
        }

        /** Define the radio rules **/ 
        [type="radio"]:checked,
        [type="radio"]:not(:checked) {
            position: absolute;  
            left: -9999px;
        }
        [type="radio"]:checked + label,
        [type="radio"]:not(:checked) + label
        {
            position: relative;
            padding-left: 28px;
            cursor: pointer;
            line-height: 20px;
            display: inline-block;
            color: #666;
            margin-bottom: 12px; 
        }
        [type="radio"]:checked + label:before,
        [type="radio"]:not(:checked) + label:before { 
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 18px;
            height: 18px;
            border: 1px solid #ddd;
            border-radius: 100%;
            background: #fff;
        }
        [type="radio"]:checked + label:after,
        [type="radio"]:not(:checked) + label:after {
            content: '';
            width: 12px;
            height: 12px;
            background: #25bbe2;
            position: absolute;
            top: 4px;
            left: 4px;
            border-radius: 100%;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }
        [type="radio"]:not(:checked) + label:after {
            opacity: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
        }
        [type="radio"]:checked + label:after {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        } 
        input[type=checkbox] + label {
            display: block;
            margin: 0.2em;
            cursor: pointer;
            padding: 0.2em;
        }
        /** Define the checkbox rules **/ 
        .checkbox{ 
            margin-top: 10px;  
            clear: both; 
        }
        .checkbox label{ 
            padding-top: 5px;
        }

        input[type=checkbox] {
            display: none;  
        } 
        input[type=checkbox] + label:before {
            content: "\2714";
            border: 0.1em solid #000;
            border-radius: 0.2em;
            display: inline-block;
            width: 1em;
            height: 1em;
            padding-left: 0.2em;
            padding-bottom: 0.3em;
            vertical-align: bottom;
            color: transparent;
            transition: .2s;
            margin-right:10px;   
            margin-top: 0px;  
        }

        input[type=checkbox] + label:active:before {
            transform: scale(0);
        }

        input[type=checkbox]:checked + label:before {
            background-color: #25bbe2;
            border-color: #25bbe2;
            color: #fff;
        }

        input[type=checkbox]:disabled + label:before {
            transform: scale(1);
            border-color: #aaa;
        }

        input[type=checkbox]:checked:disabled + label:before {
            transform: scale(1);
            background-color: #bfb;
            border-color: #bfb;
        }
        input[type=checkbox]:checked + label:before {
            background: #25bbe2 ! important; 
        }
        .heading-text {                               
            margin-top: 30px;       
            text-transform: uppercase;
            border-bottom: 1px solid #dcdcd4;
        }
        h2{ 
            font-size: 18px; 
            font-weight: 700;
            line-height: 28px; 
            margin-top: 20px; 
        } 
        p, h5, h4, a, label{
            line-height: 25px;  
            font-size: 15px;
            font-weight: 400;
        }
        a{
            color:#25bbe2; 
        }
        h5,h4 { 
            font-weight: 600;
            margin-bottom: 10px;
            color:#222222;
            text-align: left;
        }
        tr {
            clear: both; 
        }
        table{   
            border-collapse: collapse;  
            margin: 0px;
            padding: 0px;  
        }
        .table-bordered {
            border: 1px solid #f6f6f6;
            width: 100%;
        }
        .table-bordered td { 
            border: 1px solid #f6f6f6;
            text-align: left;
            font-size: 15px;
            color: #222222;  
            font-weight: 400;
            padding: 12px; 
            margin: 0px;
            background: #fff;
            z-index: 9999;
        }
        .table-bordered th{
            padding: 10px;
            z-index: -99;
            margin:0; 
        } 
        .form-control {
            border: 1px solid #f0f0f0;
            border-radius: 20px; 
            text-transform: uppercase;
            box-shadow: none; 
            font-weight: 700;
            font-size: 12px;
            padding: 15px 1%;
            color: #000;  
            width: 98%;  
            height: 15px; 
        } 
        .readonly {
            border-radius: 5px;
            border: 1px solid #999;
            margin: 0 10px;
            min-width: 120px; 
            max-height: 22px;
        }   
        .mr-top{
            margin-top: 20px; 
        }    
        .margin-left, .styled-checkbox{ 
            margin-right: 20px;     
        } 
        .margin-right{ 
            margin-left: 20px; 
        }   
        .table input[type="radio"] {
            margin: 0px auto; 
            width: 100% ! important; 
            margin-bottom: 10px; 
        } 
        .text-height{   
            min-height: 80px ! important;
        }   
        table { page-break-inside:auto; } 
        tr, th, td{ page-break-inside:avoid; page-break-after:auto } 
        thead { display:table-header-group } 
        tfoot { display:table-footer-group }  

        .heading-text-buyer, .heading-text-seller {
            margin-bottom: 20px;
            text-align: center;
            color: #222222; 
            font-weight: 600;
        }
        .buyer-details-div {
            padding-bottom: 20px;
            border-bottom: 1px solid #F2F4F4;
            display: inline-block; 
            width: 100%;
            margin-bottom: 20px;
        }
        #signature {
            color: #ff0000;
            font-size: 18px;
            font-family: Segoe Script ! important;
        }
        .signature {
            margin-bottom: 20px;
        }
        .signature-button{
            background: #92c800;
            border:1px solid #92c800;
            color: #FFF;
            padding: 6px 15px;
            border-radius: 5px;
            font-size: 15px;
        }
        .signature-model{
            padding: 25px;
        }
        .buyer-main {
            margin-top: 35px;
        }
        .buyer-details label, .seller-details label {
            margin-bottom: 10px;
        }
        .buyer-details input, .seller-details input {
            margin-bottom: 20px;
        }
        .heading-text-buyer {
            margin-top: 50%;
        }
        .heading-text-seller {
            margin-top: 15%;
        }
        .margin-bottom {
            margin-bottom:5mm;
        }
        .error{
            display: none;
        }
    </style>     
</head> 
<body>
    <div class="container purchase-sale-agreement-review contract-tools-seller-common">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-md-9 col-sm-8">
                    <div class="nested-div register-page">
                        <div class="include-text">
                            @include('frontend.contract_tools.include_files.lease_agreement_review_commom_text')
                        </div>
                        @include('frontend.contract_tools.include_files.signature_common_rent')
                    </div>
                </div>
            </div><!--</col>-->
        </div><!--</row>-->
    </div><!--</contract-tools-seller-common>-->
    <script>
                $(document).ready(function () {
                    $(':input[type=number]').on('mousewheel', function (e) {
                        $(this).blur();
                    });
				    //resize the width as per content
					function resizeInput() {
					if($(this).val().length>20){
						$(this).attr('size', $(this).val().length-25);
					}
				    else{
						$(this).attr('size', $(this).val().length);
					}
					}

					$('input[name="custom_state"]')
					// event handler
					.keyup(resizeInput)
					// resize on page load
					.each(resizeInput);
                });
	    </script>
</body>
</html>

