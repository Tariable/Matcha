@extends('layouts.app')

@section('title', 'Matcha')

@section('content')

    <div class="container-card">

        <div class="row mb-5">
        </div>
        <div class="card" id="card">
            <div class="lds-heart">
                <div></div>
            </div>
            <div class="card-body" id="cardBody" hidden>
                <div id="carousel" class="carousel">
                </div>
                <div class="match">
                    <div class="match-message">It's a Match!</div>
                </div>
                <div id="mainInfo" class="card-info">
                    <div>
                        <p id="cardName"></p>
                    </div>
                    <p id="cardDistance"></p>
                    <p id="cardId" hidden></p>
                </div>
            </div>
            <div id="match">
                <h2 id="likeResponse"></h2>
            </div>
            <div class="buttons">
                <button class="btn" id="ban" onclick="ban()">Dislike</button>
                <button class="btn" id="like" onclick="like()">Like</button>
            </div>
            <p id="cardDescription"></p>
        </div>
    </div>

    <div id="expandDiv" style="text-align: center"></div>

    <script src="{{ asset('js/Recommendations/recommendations.js') }}"></script>
@endsection
