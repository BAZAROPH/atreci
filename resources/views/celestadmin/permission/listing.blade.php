<div class="col-lg-5 bg-white">
    <h5 class="m-t-1">{{ $infosPage['element'] }}</h5>
    <table id="simpletable" class="table dt-responsive nowrap">
        <thead>
            <tr>
                <th>#</th>
                <th>Libellé</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Libellé</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
            @php ($i = 0)
            @foreach ($valeurs as $item)
                @php ($i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>
                        <a href="{{ url('celestadmin/'.$infosPage['slug'].'/edit/'.$item->id) }}" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" title="Modifier" data-original-title="Modifier">
                            <i class="icofont icofont-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
