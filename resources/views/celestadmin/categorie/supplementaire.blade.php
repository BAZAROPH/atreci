<div class="col-lg-5">
    <div class="card">
        <div class="card-block">
            <div class="md-float-material">
                @if ($infosPage['slug'] == 'categorie' or $infosPage['slug'] == 'ville' or $infosPage['slug'] == 'quartier' or $taxonomie->type_taxonomie_id == 5)
                    <div class="md-group-add-on p-relative">
                        <span class="md-add-on">
                            <i class="icofont-user"></i>
                        </span>
                        <div class="md-input-wrapper">
                            <select id="parent_id" class="md-form-control" name="parent_id">
                                <option value="">----------------</option>
                                @foreach ($type_valeurs as $type_valeur)
                                @if (empty($type_valeur->parent) or $infosPage['slug'] == 'quartier')
                                    @if (request('id'))
                                        <option value="{{ $type_valeur->id }}" {{ ( $type_valeur->id == $valeur->parent_id) ? 'selected' : '' }}>
                                            {{ $type_valeur->libelle }}
                                        </option>
                                        @if(count($type_valeur->childrens))
                                            @include('celestadmin.categorie.children', [
                                                'childrens' => $type_valeur->childrens,
                                                'nombreIteration' => 1,
                                                'page' => 'edit',
                                                'option' => $taxonomie,
                                                'category' => $valeur,
                                            ])
                                        @endif
                                    @else
                                        <option value="{{ $type_valeur->id }}" {{ ($type_valeur->id == old('parent_id')) ? 'selected' : '' }}>
                                            {{ $type_valeur->libelle }}
                                        </option>
                                        @if(count($type_valeur->childrens))
                                            @include('celestadmin.categorie.children', [
                                                'childrens' => $type_valeur->childrens,
                                                'nombreIteration' => 1,
                                                'page' => 'add',
                                                'option' => $taxonomie,
                                            ])
                                        @endif
                                    @endif
                                @endif
                                @endforeach
                            </select>
                            <label>Parent</label>
                            {{-- <select id="select-state" placeholder="Pick a state...">
                                <option value="">Select a state...</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                            </select> --}}
                        </div>
                        @error('parent_id')
                            <div class="text-danger text-center">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                @endif

                @if ($infosPage['slug'] == 'rubrique')
                    <div class="md-group-add-on p-relative">
                        <div class="md-input-wrapper" style="display: block;">
                            <div>Apparences par défaut</div>
                            <div class="form-radio">
                                @php ($i = 0)
                                @foreach ($apparences as $item)
                                    @php ($i++)
                                    <div class="my-champ">
                                        <div class="radio">
                                            <label>
                                                @if (request('id'))
                                                    @php($checked = '')
                                                    @for ($j = 0; $j < count($valeur->apparences); $j++)
                                                        @if ($valeur->apparences[$j]->id == $item->id)
                                                            @php($checked = 'checked')
                                                            @break
                                                        @endif
                                                    @endfor
                                                    <input style="margin-top: 15px;" value="{{ $item->id }}" name="apparences" type="radio" id="apparence{{ $i }}" {{ $checked }}>
                                                @else
                                                    <input style="margin-top: 15px;" value="{{ $item->id }}" name="apparences" type="radio" id="apparence{{ $i }}" {{ ($item->id == old('apparences')) ? 'checked' : '' }}>
                                                @endif

                                                <i class="helper" style="margin-top: 10px;"></i>
                                                @if(!empty($item->getMedia('image')->first()))
                                                    <img width="120" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}">
                                                @endif
                                                {{ $item->libelle }}
                                                <a class="" href="{{ url('apparences/edit/'.$item->id) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('apparences')
                            <div class="text-danger text-center">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                @endif

                @if ($infosPage['slug'] == 'rubrique')
                    <div class="md-group-add-on p-relative">
                        <div class="md-input-wrapper" style="display: block;">
                            <div>Champs</div>
                            <table id="simpletable" class="table dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>champ</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>champ</th>
                                        <th>Type</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @php ($i = 0)
                                    @foreach ($champs as $item)
                                        @php ($i++)
                                        <script type="text/javascript">
                                        function Change{{ $i }}()
                                        {
                                            if ((document.getElementById('champ{{ $i }}').checked))
                                            {
                                                document.getElementById('rai{{ $i }}').style.display="block";
                                            }
                                            else
                                            {
                                                document.getElementById('rai{{ $i }}').style.display="none";
                                            }
                                        }
                                        </script>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <div class="rkmd-checkbox checkbox-rotate checkbox-ripple">
                                                    <label class="input-checkbox checkbox-warning">
                                                        @if (request('id'))
                                                            @php($checked = '')
                                                            @php($display = 'display: none;')
                                                            @php($obligatoire1 = '')
                                                            @php($obligatoire0 = '')
                                                            @for ($j = 0; $j < count($valeur->champs); $j++)
                                                                @if ($valeur->champs[$j]->id == $item->id)
                                                                    @php($checked = 'checked')
                                                                    @php($display = '')
                                                                    @if ($valeur->champs[$j]->pivot->obligatoire == 1)
                                                                        @php($obligatoire1 = 'checked')
                                                                    @else
                                                                        @php($obligatoire0 = 'checked')
                                                                    @endif
                                                                    @break
                                                                @endif
                                                            @endfor
                                                            <input value="{{ $item->id }}" name="champs{{ $i }}" type="checkbox" id="champ{{ $i }}" onClick="Change{{ $i }}()" {{ $checked }}>
                                                        @else
                                                            <input value="{{ $item->id }}" name="champs{{ $i }}" type="checkbox" id="champ{{ $i }}" onClick="Change{{ $i }}()" {{ ($item->id == old('champs'.$i)) ? 'checked' : '' }}>
                                                            @php($display = 'display: none;')

                                                            @php($obligatoire1 = '')
                                                            @php($obligatoire0 = '')
                                                            @if (old('obligatoire'.$i) == 1)
                                                                @php($obligatoire1 = 'checked')
                                                            @endif
                                                            @if (old('obligatoire'.$i) == 0)
                                                                @php($obligatoire0 = 'checked')
                                                            @endif
                                                        @endif
                                                        <span class="checkbox"></span>
                                                    </label>
                                                    <label for="champ{{ $i }}" class="captions">{{ $item->libelle }} </label>
                                                </div>
                                                <div style="margin-left: 50px; {{ $display }}" class="form-radio" id="rai{{ $i }}">
                                                    <div class="radio">
                                                        <label>
                                                            <input value="1" type="radio" name="obligatoire{{ $i }}" {{ $obligatoire1 }}>
                                                            <i class="helper"></i>Obligatoire
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input value="0" type="radio" name="obligatoire{{ $i }}" {{ $obligatoire0 }}>
                                                            <i class="helper"></i>Facultatif
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-primary">[{{ ($item->type_champ->libelle) }}]</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @error('champs')
                            <div class="text-danger text-center">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
