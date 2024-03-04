<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ url('admin/image/logo.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('admin/image/logo.png') }}" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Laravel') }}
        @isset($title)
            | {{ $title }}
        @endisset
        &#8212; CelestAdmin
    </title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->
    {{--  <script src="{{ asset('js/app.js') }}" defer></script>  --}}
    <!-- Styles -->
    {{--  <link href="{{ asset('css/app.css') }}" rel="stylesheet">  --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Dosis|Montserrat|Nunito|Open+Sans|Oxygen|PT+Sans|Poppins|Raleway|Ubuntu&display=swap" rel="stylesheet">

    <!-- themify -->
    {{--  <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/assets/icon/themify-icons/themify-icons.css">  --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/@icon/themify-icons/themify-icons.css">

    <!-- iconfont -->
    {{--  <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/assets/icon/icofont/css/icofont.css">  --}}
    <link rel="stylesheet" href="https://allyoucan.cloud/cdn/icofont/1.0.1/icofont.css">

    <!-- simple line icon -->
    {{--  <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/assets/icon/simple-line-icons/css/simple-line-icons.css">  --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/bower/bootstrap/dist/css/bootstrap.min.css">

    <!-- Chartlist chart css -->
    <link rel="stylesheet" href="https://cdn.qenium.com/bower/chartist/dist/chartist.css" type="text/css" media="all">

    <!-- Weather css -->
    <link href="https://cdn.qenium.com/assets/css/svg-weather.css" rel="stylesheet">

    <!-- Font Awesone -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Date Picker css -->
	<link rel="stylesheet" href="https://cdn.qenium.com/bower/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" />

	<!-- Bootstrap Date-Picker css -->
	<link rel="stylesheet" href="https://cdn.qenium.com/assets/plugins/bootstrap-datepicker/css/bootstrap-datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.qenium.com//bower/bootstrap-daterangepicker/daterangepicker.css" />

    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/bower/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/assets/plugins/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/bower/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    <!-- Dropzone css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/bower/dropzone/dist/dropzone.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.qenium.com/assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/design.css') }}">
    @livewireStyles
</head>
<body class="sidebar-mini fixed">
    {{-- <div class="loader-bg">
        <div class="loader-bar">
        </div>
    </div> --}}
    {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav> --}}

    <main class="py-4">
        @yield('content')
    </main>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <!-- Required Jqurey -->
    {{-- <script src="https://cdn.qenium.com/bower/Jquery/dist/jquery.min.js"></script> --}}
    <script src="https://cdn.qenium.com/bower/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://cdn.qenium.com/bower/tether/dist/js/tether.min.js"></script>

    <!-- Required Fremwork -->
    <script src="https://cdn.qenium.com/bower/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Scrollbar JS-->
    <script src="https://cdn.qenium.com/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="https://cdn.qenium.com/bower/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>

    <!--classic JS-->
    <script src="https://cdn.qenium.com/bower/classie/classie.js"></script>

    <!-- notification -->
    <script src="https://cdn.qenium.com/assets/plugins/notification/js/bootstrap-growl.min.js"></script>

    <!--form validation Custom js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="https://cdn.qenium.com/assets/plugins/forms-wizard-validation/js/validate.js"></script>

    <!-- Date picker.js -->
    <script src="https://cdn.qenium.com/bower/moment/moment.js"></script>
    <script src="https://cdn.qenium.com/bower/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Sparkline charts -->
    <script src="https://cdn.qenium.com/bower/jquery-sparkline/dist/jquery.sparkline.js"></script>

    <!-- Counter js  -->
    <script src="https://cdn.qenium.com/bower/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="https://cdn.qenium.com/assets/plugins/countdown/js/jquery.counterup.js"></script>

    <!-- Echart js -->
    <script src="https://cdn.qenium.com/assets/plugins/charts/echarts/js/echarts-all.js"></script>

    <!-- highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>


    <!-- waves effects.js -->
    <script src="https://cdn.qenium.com/bower/Waves/dist/waves.min.js"></script>

    <!-- data-table js -->
    <script src="https://cdn.qenium.com/bower/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.qenium.com/bower/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.qenium.com/assets/plugins/data-table/js/jszip.min.js"></script>
    <script src="https://cdn.qenium.com/assets/plugins/data-table/js/pdfmake.min.js"></script>
    <script src="https://cdn.qenium.com/assets/plugins/data-table/js/vfs_fonts.js"></script>
    <script src="https://cdn.qenium.com/bower/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="https://cdn.qenium.com/bower/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="https://cdn.qenium.com/bower/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.qenium.com/bower/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.qenium.com/bower/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Dropzone js -->
    <script src="https://cdn.qenium.com/bower/dropzone/dist/dropzone.js"></script>

    <!-- ace editor js -->
    <script type="text/javascript" src="https://cdn.qenium.com/assets/plugins/ace-editor/build/aui/aui.js"></script>

    <!-- Date picker.js -->
	<script src="https://cdn.qenium.com/assets/plugins/datepicker/js/moment-with-locales.min.js"></script>
    <script src="https://cdn.qenium.com/bower/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker js -->
	<script type="text/javascript" src="https://cdn.qenium.com/bower/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.qenium.com/assets/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js"></script>

    <!-- bootstrap range picker -->
	<script type="text/javascript" src="https://cdn.qenium.com/bower/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- custom js -->
    {{-- <script type="text/javascript" src="{{ asset('admin/js/ace-editor-custom.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdn.qenium.com/assets/js/main.min.js"></script>
    {{--  <script src="{{ asset('admin/pages/form-validation.js') }}"></script>  --}}
    <script src="{{ asset('admin/pages/data-table.js') }}"></script>
    {{--  <script type="text/javascript" src="{{ asset('admin/pages/dashboard.js') }}"></script>  --}}
    <script type="text/javascript" src="https://cdn.qenium.com/assets/pages/elements.js"></script>
    <script src="https://cdn.qenium.com/assets/js/menu.min.js"></script>
    {{-- <script type="text/javascript" src="https://cdn.qenium.com/assets/pages/advance-form.js"></script> --}}

    {{--  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.3.2/tinymce.min.js"></script>  --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>

    {{-- <script src="{{ asset('admin/js/dropzone.js') }}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script> --}}
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('storeMedia') }}',
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            maxFiles: 8,
            dictDefaultMessage: 'Cliquez ici pour ajouter vos images !!<br> 8 images max',
            dictFallbackMessage: "Votre navigateur ne supporte pas le téléchargement de fichiers drag'n'drop.",
            dictFallbackText: "Veuillez utiliser le formulaire de secours ci-dessous pour télécharger vos fichiers comme auparavant.",
            dictInvalidFileType: "Vous ne pouvez pas télécharger des fichiers de ce type.",
            dictCancelUpload: "Annuler",
            dictCancelUploadConfirmation: "Êtes-vous sûr de vouloir annuler ce téléchargement ?",
            dictRemoveFile: "Supprimer",
            dictRemoveFileConfirmation: null,
            dictMaxFilesExceeded: "Vous ne pouvez pas télécharger d'autres fichiers.",
            acceptedFiles: "image/*",
            paramName: 'file',
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }
            $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($project) && $project->document)
                    var files =
                    {!! json_encode($project->document) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    }
                @endif
            }
        }
    </script>

    @if (!isset($mode))
        @php($mode = 'html')
    @endif
    <script>
        $(document).ready(function () {
            $('#parent_id').selectize({
                sortField: 'text'
            });
        });
        /*tinymce.init({
            selector: 'textarea',
        });*/
        ClassicEditor
        .create( document.querySelector( '#description' ) )
        .then(editor => {
            console.log( editor );
        })
        .catch(error => {
            console.error( error );
        });

        ClassicEditor
        .create( document.querySelector( '#resume' ) )
        .then(editor => {
            console.log( editor );
        })
        .catch(error => {
            console.error( error );
        });

        ClassicEditor
        .create( document.querySelector( '#caracteristique' ) )
        .then(editor => {
            console.log( editor );
        })
        .catch(error => {
            console.error( error );
        });

        $('#flash-overlay-modal').modal();

        AUI().ready('aui-ace-editor', function(A) {
            @if ($mode == 'sql')
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/cobalt");
                editor.getSession().setMode("ace/mode/{{ $mode }}");

                var input = $('textarea[name="requete"]');
                    editor.getSession().on("change", function () {
                    input.val(editor.getSession().getValue());
                });
            @endif

            var debut = ace.edit("debut");
            debut.setTheme("ace/theme/cobalt");
            debut.getSession().setMode("ace/mode/{{ $mode }}");

            var debutHide = $('textarea[name="debut"]');
                debut.getSession().on("change", function () {
                debutHide.val(debut.getSession().getValue());
            });

            var fin = ace.edit("fin");
            fin.setTheme("ace/theme/cobalt");
            fin.getSession().setMode("ace/mode/{{ $mode }}");

            var finHide = $('textarea[name="fin"]');
                fin.getSession().on("change", function () {
                finHide.val(fin.getSession().getValue());
            });

            // Le code de l'apparence
            var code = ace.edit("code");
            code.setTheme("ace/theme/cobalt");
            code.getSession().setMode("ace/mode/{{ $mode }}");

            var codeHide = $('textarea[name="code"]');
                code.getSession().on("change", function () {
                codeHide.val(code.getSession().getValue());
            });
        });

        $('#date_planification').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "showCustomRangeLabel": false,
            "alwaysShowCalendars": true,
            "format": 'YYYY-MM-DD HH:mm',
            //"startDate": "11/30/2016",
            //"endDate": "12/06/2016",
            "drops": "down"
        });

        $('#date_fin').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "showCustomRangeLabel": false,
            "alwaysShowCalendars": true,
            "format": 'YYYY-MM-DD HH:mm',
            //"startDate": "11/30/2016",
            //"endDate": "12/06/2016",
            "drops": "down"
        });

        $('#date_debut').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "showCustomRangeLabel": false,
            "alwaysShowCalendars": true,
            "format": 'YYYY-MM-DD HH:mm',
            //"startDate": "11/30/2016",
            //"endDate": "12/06/2016",
            "drops": "down"
        });

        $('#antidater').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "showCustomRangeLabel": false,
            "alwaysShowCalendars": true,
            "format": 'YYYY-MM-DD HH:mm',
            //"startDate": "11/30/2016",
            //"endDate": "12/06/2016",
            "drops": "down"
        });

        $('#date').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": false,
            "showCustomRangeLabel": false,
            "alwaysShowCalendars": true,
            "format": 'YYYY-MM-DD HH:mm',
            //"startDate": "11/30/2016",
            //"endDate": "12/06/2016",
            "drops": "down"
        });


        /*$('#champ1').change(function() {
            var champ = $(this).val();
            if(champ = 1){
                $('.my-radio1').show();
            }
            else if(champ = 0){
                $('.my-radio1').hide();
            }
        });*/
    </script>

    <script src="{{ asset('admin/js/repeater.js') }}" type="text/javascript"></script>
    <script>
        /* Create Repeater */
        $("#repeater").createRepeater({
            showFirstItemToDefault: true,
        });

        // date Range Picker
        $('input[name="daterange"]').daterangepicker();
        $(function() {
            $('input[name="birthdate"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true
                },
                function(start, end, label) {
                    var years = moment().diff(start, 'years');
                    alert("You are " + years + " years old.");
                });

            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });
            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format(' D, MMMM, YYYY') + ' - ' + end.format('D, MMMM, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                lang: 'fr',
                "drops": "down",
                locale: {
                    format: 'DD-MM-YYYY'
                },
                ranges: {
                    'Aujourdhui': [moment(), moment()],
                    'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 derniers jours': [moment().subtract(6, 'days'), moment()],
                    '30 derniers jours': [moment().subtract(29, 'days'), moment()],
                    'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                    'Mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Cette année': [moment().startOf('year'), moment().endOf('year')],
                    'L\'année dernière': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                    @php($k = 0)
                    @for ($i = date('Y'); $i >= 2016; $i--)
                        '{{ $i }}': [moment().subtract({{ $k }}, 'year').startOf('year'), moment().subtract({{ $k }}, 'year').endOf('year')],
                        @php($k++)
                    @endfor
                }
            }, cb);

            cb(start, end);

            $('.input-daterange input').each(function() {
                $(this).datepicker();
            });
            $('#sandbox-container .input-daterange').datepicker({
                todayHighlight: true
            });
            $('.input-group-date-custom').datepicker({
                todayBtn: true,
                clearBtn: true,
                keyboardNavigation: false,
                forceParse: false,
                todayHighlight: true,
                defaultViewDate: {
                    year: '2017',
                    month: '01',
                    day: '01'
                }
            });
            $('.multiple-select').datepicker({
                todayBtn: true,
                lang: 'fr',
                clearBtn: true,
                multidate: true,
                keyboardNavigation: false,
                forceParse: false,
                todayHighlight: true,
                defaultViewDate: {
                    year: '2017',
                    month: '01',
                    day: '01'
                }
            });
            $('#config-demo').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "timePickerSeconds": true,
                "showCustomRangeLabel": false,
                "alwaysShowCalendars": true,
                "startDate": "11/30/2016",
                "endDate": "12/06/2016",
                "drops": "up"
            }, function(start, end, label) {
                console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
            });
        });
    </script>
    @livewireScripts
    @stack('scripts')

</body>
</html>
