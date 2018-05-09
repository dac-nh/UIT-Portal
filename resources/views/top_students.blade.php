<div class="beehive text-center col-md-12 col-md-offset-2 ">
    <div class="bee-cell-1">
        <div class="bee-cell">
            <label class="bee-cell-text">Top 5 Sinh Viên</label>
        </div>
    </div>
    <div class="bee-cell-2">
        <div class="bee-cell">
            <a href="{{$top_students[0]['url']}}">
                <img src="{{$top_students[0]['avatar']}}" class="bee-cell-image"/>
            </a>
        </div>
    </div>
    <div class="bee-cell-3">
        <div class="bee-cell">

        </div>
    </div>
    <div class="bee-cell-4">
        <div class="bee-cell">
            <a href="{{$top_students[1]['url']}}">
                <img src="{{$top_students[1]['avatar']}}" class="bee-cell-image"/>
            </a>
        </div>
    </div>
    <div class="bee-cell-5">
        <div class="bee-cell">
            <a href="{{$top_students[2]['url']}}">
                <img src="{{$top_students[2]['avatar']}}" class="bee-cell-image"/>
            </a>
        </div>
    </div>
    <div class="bee-cell-6">
        <div class="bee-cell">
            <a href="{{$top_students[3]['url']}}">
                <img src="{{$top_students[3]['avatar']}}" class="bee-cell-image"/>
            </a>
        </div>
    </div>
    <div class="bee-cell-7">
        <div class="bee-cell">
            <a href="{{$top_students[4]['url']}}">
                <img src="{{$top_students[4]['avatar']}}" class="bee-cell-image"/>
            </a>
        </div>
    </div>
    <div class="bee-cell-8">
        <div class="bee-cell">
            <label class="bee-cell-text">Được Đánh Giá Cao</label>
        </div>
    </div>
</div>
<style>
    .beehive {
    }

    .bee-cell:before {
        content: " ";
        width: 0;
        height: 0;
        border-right: 30px solid #0067AF;
        border-top: 52px solid transparent;
        border-bottom: 52px solid transparent;
        position: absolute;
        left: -30px;
        z-index: 1507;
    }

    .bee-cell {
        width: 60px;
        height: 104px;
        background-color: #0067AF;
        position: relative;
    }

    .bee-cell:after {
        content: "";
        width: 0;
        top: 0px;
        position: absolute;
        right: -30px;
        border-left: 30px solid #0067AF;
        border-top: 52px solid transparent;
        border-bottom: 52px solid transparent;
        z-index: 1507;
    }

    .bee-cell-1 {
        margin-top: 100px;
    }

    .bee-cell-2 {
        margin-top: -160px;
        margin-left: 100px;
    }

    .bee-cell-3 {
        margin-left: 100px;
        margin-top: 10px;
    }

    .bee-cell-4 {
        margin-left: 200px;
        margin-top: -160px
    }

    .bee-cell-5 {
        margin-left: 200px;
        margin-top: 10px
    }

    .bee-cell-6 {
        margin-top: -45px;
        margin-left: 100px;
    }

    .bee-cell-7 {
        margin-top: 10px;
        margin-left: 100px;
    }

    .bee-cell-8 {
        margin-top: 30px;
        margin-left: 100px;
    }

    .bee-cell-image {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 80px;
        width: 80px;
        border-radius: 30px;
        z-index: 1571;
    }

    .bee-cell-text {
        color: whitesmoke;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
