
        @foreach($data as $zip => $row)
        <div class="alert alert-{{$row['type']}} px-3 py-2">        
            <h4 class="fs-6">{{$row['title']}}!</h4>
            <hr class="m-0 mb-2">
            @foreach($row["message"] as $line)
            <p class="m-0">{{$line}}</p>
            @endforeach
        </div>
        @endforeach