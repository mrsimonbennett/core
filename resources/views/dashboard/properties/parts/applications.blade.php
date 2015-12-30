@if(count($property_applications))
    <div class="ibox-content p-xl m-t m-b">
        <h4>Applications ({{count($property_applications)}})</h4>

        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Completed</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($property_applications as $application)
                <?php //dd($application)?>
                <tr>
                    <td>{{$application->applicant->known_as}}</td>
                    <td>{{(new \Carbon\Carbon($application->finished_at))->diffForHumans()}}</td>
                    <td><a href="/applications/{{$application->id}}" class="btn btn-xs btn-primary">View/Review</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
