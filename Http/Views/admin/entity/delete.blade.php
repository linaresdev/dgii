@extends("dgii::admin.entity.layout")

    @section("content")
        <article class="card border-0 mt-3">
            <section class="card-body">
                <h5 class="card-title">
                    {{__("business.delete.title")}}
                </h5>
                <p>{{__("business.delete.info")}}</p>
                <ul>
                    @foreach(__("business.delete.driving") as $row)
                    <p>{{$row}}</p>
                    @endforeach
                </ul>

                <form action="#" class="border border-danger rounded p-4">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <span class="mdi mdi-delete"></span>
                        {{__("words.delete")}}
                    </button>
                    <a href="{{__url('admin/entities')}}" class="btn btn-light">
                        <span class="mdi mdi-close-thick"></span>
                        {{__("words.close")}}
                    </a>
                </form>
            </section>
        </article>
    @endsection