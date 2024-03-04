<div class="col-lg-4 bg-white">
    <h5 class="m-t-1">ID Taxonomie pour requête</h5>
    <table id="simpletable" class="table dt-responsive nowrap">
        <thead>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
            </tr>
        </tfoot>
        <tbody>
            @php ($i = 0)
            @foreach ($taxonomies as $item)
            @php ($i++)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    <span data-toggle="tooltip" data-placement="top" title="{!! strip_tags($item->description) !!}" data-original-title="{!! strip_tags($item->description) !!}">
                        <i class="{{ $item->icon }} text-warning-color"></i>
                        {{ $item->libelle }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
