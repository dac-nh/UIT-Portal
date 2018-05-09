<div class="row" ng-controller="CarouselController">
    <div uib-carousel active="active" interval="myInterval" no-wrap="noWrapSlides">
        <div uib-slide ng-repeat="slide in slides track by slide.id" index="$index">
            <img ng-src="<%slide.image%>" height="300px">
        </div>
    </div>
</div>
