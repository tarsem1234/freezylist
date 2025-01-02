@extends('backend.layouts.app')

@if( isset($categorySession) )
@section ('title', ('Edit Session'))
@else
@section ('title', ('Create Session'))
@endif

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection


@section('page-header')
@if( isset($categorySession) )
<h1>Edit Session</h1>
@else
<h1>Add New Session for {{ $category->category }}</h1>
@endif
@endsection


@section('content')
<section id="add_edit_session" v-cloak>
    <section v-if='successbox.show'>
        <div class="box box-success" id="">
            <div class="box-header with-border"></div>
            <div class="box-body">
                <div class="container text-center col-md-12">
                    <div class="alert alert-success"><strong>Success: </strong> @{{successbox.message}}</div>
                    <a href="{{route('admin.categories.index')}}">Back to categories listing</a>
                </div>
            </div>
    </section>
    <section v-else>
        <div class="box box-success">
            <div class="box-header with-border">
                @if( isset($categorySession) )
                <h3 class="box-title">Edit Session</h3>
                @else
                <h3 class="box-title">Create Session</h3>
                @endif
                <div class="box-tools pull-right">

                </div>
            </div>

            <div class="box-body">
                <div class="container">
                    @if( isset($categorySession) )
                    {{ html()->modelForm($categorySession, 'PUT', route('admin.sessions.update', $categorySession['id']))->class('form-horizontal')->acceptsFiles()->open() }}
                    @else
                    {{ html()->form('POST', route('admin.sessions.store'))->class('form-horizontal')->acceptsFiles()->open() }}
                    @endif
                </div>
                <div v-if="errors.length" class="text-danger error-list">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li v-for="error in errors" v-html='error'></li>
                    </ul>
                </div>
                @if(isset($category))
                {{ html()->hidden('category_id', $category->id) }}
                @endif
                @if(isset($categorySession))
                {{ html()->hidden('category_id', $categorySession->category->id) }}
                @endif
                <div class="row form-group">
                    <div class="col-sm-1">
                        {{ html()->label('Name:', 'name') }}
                    </div>
                    <div class="col-sm-4">
                        {{ html()->text('name')->class('form-control title-input')->maxlength('191')->placeholder('Name')->attribute('v-model', 'session.name') }}
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-1">
                            {{ html()->label('Points:', 'points') }}
                        </div>
                        <div class="col-sm-4">
                            {{ html()->number('points')->class('form-control title-input')->attribute('maxlength', '191')->attribute('required', 'required')->attribute('placeholder', 'Points')->attribute('v-model', 'session.points') }}
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-1">
                        {{ html()->label('Description:', 'description') }}
                    </div>
                    <div class="col-sm-11">
                        {{ html()->textarea('description')->id('ckeditor')->class('form-control textarea')->maxlength('191')->required()->placeholder('Description')->attribute('v-model', 'session.description') }}
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-1">
                        {{ html()->label('Questions:', 'questions') }}
                    </div>
                    <div class="col-sm-11">
                        <table class="col-sm-12 table table-bordered" id="main_table" border="1" cellpadding="5">
                            <thead>
                                <tr>
                                    <td>#.</td>
                                    <td>Name</td>
                                    <td>Type</td>
                                    <td>Options(Mark correct answer)</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(question, index) in session.questions" v-bind:key="index">
                                    <td>@{{index+1}}</td>
                                    <td>
                                        <textarea rows="3" name="questions[0][question]" required="true" v-model="question.question" class="form-control"></textarea>
                                    </td>
                                    <td>
                                        <select name="questions[0][type]" class="checkbox_or_radio" v-model="question.type" @change="resetCorrectAnswers(question)">
                                            <option value="{{ config('constant.inverse_session_question_type.Radio') }}">Radio</option>
                                            <option value="{{ config('constant.inverse_session_question_type.Checkbox') }}">Checkbox</option>
                                        </select>
                                    </td>
                                    <td class="answer_option">
                                        <div class="more_answer_option">
                                            <p v-for="(option, optionIndex) in question.options">
                                                <input v-model="option.title" type="text" required="true">
                                                <span v-if="question.type=='{{config('constant.inverse_session_question_type.Checkbox')}}'">
                                                    <input type="checkbox" name="correct_answer" v-model="option.correct_answer">
                                                </span>
                                                <span v-else>
                                                    <input 
                                                        type="radio" 
                                                        v-model="option.correct_answer"
                                                        v-bind:value="1"
                                                        @change="markCorrectAnswer(question, option)"
                                                        >
                                                </span>
                                                <button type="button" class="btn btn-danger delete_option" title="delete" @click="addRemoveOptions(question, optionIndex)"><i class=" fa fa-trash-o"></i></button>
                                            </p>
                                        </div>
                                        <button type="button" class="btn btn-info add_more_options" title="addoption" @click="addRemoveOptions(question, -1)">Add More Options</button>
                                    </td>
                                    <td><button type="button" class="btn btn-danger delete_question" title="delete" @click="addRemoveQuestions(index)">Delete Question</button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"><button type="button" class="btn btn-info add_more_questions" title="add" @click="addRemoveQuestions(-1)">Add More Questions</button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <div class="box box-info  create-edit-cancel-btn">
            {{ html()->button('Save', 'button')->class('btn btn-primary edit-create-btn')->attribute('@click', 'checkForm()') }}
            <a href="{{route("admin.sessions.index")}}" class="btn btn-primary cancel-btn">Cancel</a>
        </div>
        {{ html()->closeModelForm() }}
    </section>
</section>
<style>
    [v-cloak] > * { display:none }
    [v-cloak]::before { content: "loading…" }
    .table > tbody > tr > td {
        vertical-align: middle;
    }
</style>
@endsection

@section('after-scripts')
<?php
$emptyOption = [0 => ['title' => '', 'correct_answer' => 0]];
$emptyQuestions = [0 => ['question' => '', 'type' => config('constant.inverse_session_question_type.Checkbox'), 'options' => $emptyOption]];
$emptySession = [
    "category_id" => isset($categorySession) ? @$categorySession->category->id : $category->id,
    "name" => '',
    "description" => '',
    "points" => '',
    "questions" => $emptyQuestions
];
?>
<script src="{{ asset("ckeditor/ckeditor.js") }}"></script>
<script>
    $(function () {
        CKEDITOR.editorConfig = function (config) {
            config.toolbar = [
                {name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
                {name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                {name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
                {name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
                '/',
                {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
                '/',
                {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                {name: 'about', items: ['About']}
            ];
        };
        CKEDITOR.replace('ckeditor');
    });
    var errorList = 0;
    var save_session_route = "{{route('admin.sessions.save')}}";
    new Vue({
        el: '#add_edit_session',
        data: {
            errors: [], saveClick: false, save_session_route: save_session_route, successbox: {show: false, message: ''},
            session: @json($categorySession ?? $emptySession)
        },
        methods: {
            addRemoveQuestions(index) {
                if (index === -1) {
                    this.session.questions.push(@json($emptyQuestions[0]))
                } else {
                    if (this.session.questions.length > 1)
                        this.session.questions.splice(index, 1);
                }
            },
            addRemoveOptions(question, index) {
                if (index === -1) {
                    question.options.push(@json($emptyOption[0]))
                } else {
                    if (question.options.length > 1)
                        question.options.splice(index, 1);
                }
            },
            resetCorrectAnswers(question) {
                for (var i = 0; i < question.options.length; i++) {
                    question.options[i].correct_answer = 0;
                }
            },
            markCorrectAnswer(question, option) {
                if (question.type == "{!! config('constant.inverse_session_question_type.Radio') !!}") {
                    this.resetCorrectAnswers(question);
                    option.value = 1;
                    option.correct_answer = 1;
                }
            },
            scrollTop(val = 100) {
                $('html, body').animate({
                    scrollTop: $(".box-body").offset().top - val
                }, 500);
            },
            checkForm() {
                this.session.description = CKEDITOR.instances.ckeditor.getData();
                this.errors = [];
                if (!this.session.name)
                    this.errors.push('Name is required');
                if (!this.session.points)
                    this.errors.push('Points are required');
                if (!this.session.description)
                    this.errors.push('Description are required');
                questions = this.session.questions;
                var questionIndex = 1;
                for (var i = 0; i < questions.length; i++) {
                    var errorText = '';
                    if (!questions[i].question)
                        errorText += "<li>Name is empty</li>";
                    var optionErrors = 0;
                    var selectedAnswer = 0;
                    for (var o in questions[i].options) {
                        if (!questions[i].options[o].title)
                            optionErrors++;
                        if (questions[i].options[o].correct_answer)
                            selectedAnswer++
                    }
                    if (optionErrors > 0) {
                        var text = optionErrors == 1 ? "1 Option is " : optionErrors + " options are";
                        errorText += "<li>" + text + " empty</li>";
                    }

                    if (selectedAnswer == 0)
                        errorText += "<li>Correct answer not marked</li>";
                    if (errorText != '')
                        this.errors.push("Question " + (questionIndex) + " has following problems: <ul>" + errorText + '</ul>');
                    questionIndex++;
                }
                if (this.errors.length > 0) {
                    this.scrollTop();
                } else {
                    var vr = this;
                    axios.post(this.save_session_route, this.session).then(function (response) {
                        data = response.data;
                        if (data.status != true) {
                            vr.errors.push(data.message);
                        } else {
                            vr.successbox.show = true;
                            vr.successbox.message = data.message;
                        }
                        vr.scrollTop(300);
                    }).catch(error => {
                        vr.errors.push(error.response.statusText);
                        vr.scrollTop(300);
                    });
                }
            },
        }
    });
</script>
@endsection
