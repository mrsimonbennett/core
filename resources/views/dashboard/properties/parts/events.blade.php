    <h2>Property Events</h2>

    <div class="feed-activity-list">
        @foreach($propertyHistory as $event)
        <div class="feed-element">
            <a href="#" class="pull-left">
            </a>
            <div class="media-body ">
                <small class="pull-right text-navy">{{(new \Carbon\Carbon($event->event_happened))->diffForHumans()}}</small>
                <strong>{{$event->event_name}}</strong>.
            </div>
        </div>
        @endforeach

    </div>