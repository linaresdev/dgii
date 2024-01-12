
            @foreach($data as $zip => $row)
            <div class="mb-2 border-start border-end border-3 rounded border-{{$row['type']}} bg-{{$row['type']}}-subtle ps-2 py-2">
                @foreach($row["message"] as $note)
                <p class="m-0 text-{{$row['type']}} fs-6">{{$note}}</p>
                @endforeach                
            </div>
            @endforeach