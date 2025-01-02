@extends('frontend.layouts.app')

@section('title', app_name() . ' | Learning Center')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<style>#learning_center{ font-weight: bold;color: #000;}</style>
@endsection 
@section('content')
<div class="forum-page signer-page dashboard-page associates profile-view learning-center">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div" id="quiz-box">
                    <div class="profile right-dashboard-div-text">
                        <div class="row">  
                            <div class="col-md-12">
                                <h4 class="pull-left m-bottom">Learning Session: {{$session->name}}</h4> 
                            </div>
                        </div>
                        <hr class="lc_hr" />
                        <div class="session-desc">
                            <div class="l-descr">{!! $session->description !!}</div>
                        </div>
                    </div>

                    <div class="time-to-review">
                        <div class="col-lg-12 col-sm-12 col-xs-12 mar-top">
                            <div class="row"> 
                                <div class="right-dashboard-div-text">
                                    <section v-if="!sessionCompleted">
                                        <h4>Quick Review</h4>
                                        <hr class="lc_hr" />
                                        <div class="box-inner">
                                            <div class="description"><h4>@{{question.question}}</h4></div>
                                            <fieldset>
                                                <legend>Select Your Response(s)</legend>
                                                <ul class="q_options" v-bind:class="{'checkbox' : question.type=='checkbox'}">
                                                    <li v-for="(option, optionIndex) in question.options" v-bind:key="optionIndex"> 
                                                        <input 
                                                            v-bind:type="question.type" 
                                                            v-bind:id="'option_'+option.id" 
                                                            v-bind:value="optionIndex"
                                                            v-model="selectedAnswer"
                                                            v-bind:class=" {'styled-checkbox' : question.type=='checkbox'} "
                                                            @change="checkAnswer(option)"
                                                            >
                                                        <label v-bind:for="'option_'+option.id">@{{option.title}}</label>
                                                        <span class="answer-help" v-html="option.message"></span>
                                                    </li>
                                                </ul>
                                            </fieldset>
                                            <div class="btns-green-blue pull-right submit_question_btn" v-if="isCorrect">
                                                <span class="message" v-html="response.message"></span>
                                                <a href="javascript:void(0)" class="btn btn-blue" @click="submitAnswer()">Submit</a>
                                            </div>
                                        </div>
                                    </section>
                                    <section v-else>
                                        <div class="btns-green-blue">
                                            <div class="alert alert-success"><strong>Success:</strong> Your Session is Complete!</div>
                                            @if($isBonusSession)
                                            <a href="{{route('frontend.learning.center')}}" class="btn btn-blue pull-right">Return</a>
                                            @else
                                            <a href="{{route('frontend.learning.topic', $session->category_id)}}" class="btn btn-blue pull-right">Continue</a>
                                            @endif
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after-scripts')
<script>
    var quiz = new Vue({
        el: '#quiz-box',
        data: {
            response: {message: ''},
            session: <?= $session ?>,
            question: {},
            selectedAnswer: [],
            isCorrect: false,
            inCorrectAnswerMessage: "<span class='text-danger'>I'm sorry, that is incorrect. Please try again.</span>",
            correctAnwerMessage: "<span class='text-success'>Correct!!</span>",
            sessionCompleted: false
        },
        methods: {
            unsetOptionMessage(options) {
                for (var i = 0; i < options.length; i++)
                    options[i].message = '';
            },
            nextQuestion() {
                this.question = this.session.questions[0];
                this.question.type = this.question.type == 1 ? 'radio' : 'checkbox';
                this.selectedAnswer = [];
                this.isCorrect = false;
            },
            submitAnswer() {
                this.session.questions.splice(0, 1);
                var vr = this;
                var saveOrUpdate = this.session.questions.length > 0 ? 'save' : 'finish';
                var dataToBePosted = {
                    s_id: this.session.id,
                    q_id: this.question.id,
                    save: saveOrUpdate,
                    isBonus: "{{$isBonusSession ? 1 : 0}}"
                };
                axios.post("{{route('frontend.submit.answer')}}", dataToBePosted).then(function (res) {
                    result = res.data;
                    if (result.status == 'failed') {
                        vr.response.message = "<span class='text text-danger'>" + result.message + "</span>";
                    } else {
                        if (vr.session.questions.length > 0) {
                            vr.nextQuestion();
                        } else {
                            vr.sessionCompleted = true;
                        }
                        vr.response.message = "";
                    }
                });
            },
            checkAnswer(option) {
                options = this.question.options;
                this.unsetOptionMessage(options);
                if (Array.isArray(this.selectedAnswer)) {
                    this.selectedAnswer.sort();
                    var correctAnwers = [];
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].correct_answer == 1)
                            correctAnwers.push(i);
                    }
                    this.isCorrect = false;
                    if (this.selectedAnswer.length == correctAnwers.length) {
                        var errorsLength, correctLength = 0;
                        for (var j = 0; j < this.selectedAnswer.length; j++) {
                            if (correctAnwers.indexOf(this.selectedAnswer[j]) >= 0)
                                correctLength++;
                            else
                                errorsLength++;
                        }
                        this.isCorrect = this.selectedAnswer.length == correctLength ? true : false;
                    }
                    for (var k = 0; k < this.selectedAnswer.length; k++) {
                        selectedOpt = options[this.selectedAnswer[k]];
                        selectedOpt.message = selectedOpt.correct_answer == 1 ? this.correctAnwerMessage : this.inCorrectAnswerMessage;
                    }
                } else {
                    option.message = this.inCorrectAnswerMessage;
                    if (options[this.selectedAnswer].correct_answer == 1) {
                        this.isCorrect = true;
                        option.message = this.correctAnwerMessage;
                    } else {
                        this.isCorrect = false;
                    }
                }
            }
        },
        mounted() {
            this.nextQuestion();
        }
    });
</script>
@endsection