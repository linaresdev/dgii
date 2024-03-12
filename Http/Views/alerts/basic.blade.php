
        @foreach($data as $zip => $row)
        <div class="mb-2">
            @foreach($row["message"] as $note)
            <p class="m-0 text-{{$row['type']}} fs-7">{{$note}}</p>
            @endforeach                
        </div>
        @endforeach