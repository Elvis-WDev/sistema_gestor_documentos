@extends('layouts.master')
@section('title')
    DigiDocs || Módulos
@endsection


@section('content')
    <style type="text/css">
        .bg-folder-shaper {
            width: 100%;
            height: 115px;
            border-radius: 0px 15px 15px 15px !Important;
        }

        .folder-shape-top {
            width: 57px;
            height: 17px;
            border-radius: 20px 37px 0px 0px;
            position: absolute;
            top: -16px;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .widget-user-2 .widget-user-username,
        .widget-user-2 .widget-user-desc {
            margin-left: 10px;
            font-weight: 400;
            font-size: 17px;
        }

        .widget-user-username {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-t-20 {
            margin-top: 20px;
        }

        .dropdown-menu {
            min-width: 100%;
        }

        .doc-box.box {
            box-shadow: 0 0px 0px rgba(0, 0, 0, 0.0) !important;
        }

        .bg-folder-shaper:hover {
            background-color: yellow;
        }

        .select2-container {
            width: 100% !important;
        }

        #filterForm.in,
        filterForm.collapsing {
            display: block !important;
        }
    </style>
    <section class="content-header">
        <h1 class="pull-left">
            Documentos
        </h1>
        <h1 class="pull-right">
            <a href="{{ route('crear-custom-module') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Nuevo
            </a>
        </h1>
    </section>
    <div class="content" style="margin-top: 22px;">
        <div class="clearfix"></div>


        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    @php
                        $Modulo = \App\Models\ModuloPersonalizado::all();
                    @endphp
                    @foreach ($Modulo as $modulo)
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 m-t-20" style="cursor:pointer;">
                            <div class="doc-box box box-widget widget-user-2">
                                <div class="widget-user-header bg-gray bg-folder-shaper no-padding">
                                    <div class="folder-shape-top bg-gray"></div>
                                    <div class="box-header">
                                        <a href="http://localhost/Plantillas/digidocu-1.0.4/public/admin/documents/1"
                                            style="color: black;">
                                            <h3 class="box-title"><i class="fa fa-folder text-yellow"></i></h3>
                                        </a>

                                        <div class="box-tools pull-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false"
                                                    style="    background: transparent;border: none;">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                                    <li><a
                                                            href="http://localhost/Plantillas/digidocu-1.0.4/public/admin/documents/1">Show</a>
                                                    </li>
                                                    <li><a
                                                            href="http://localhost/Plantillas/digidocu-1.0.4/public/admin/documents/1/edit">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form method="POST"
                                                            action="http://localhost/Plantillas/digidocu-1.0.4/public/admin/documents/1"
                                                            accept-charset="UTF-8"><input name="_method" type="hidden"
                                                                value="DELETE"><input name="_token" type="hidden"
                                                                value="6Dw75leyO8tbyEhDByInAXIzdZBvLLM0xbsSePwt">
                                                            <button type="submit" class="btn btn-link"
                                                                onclick="return conformDel(this,event)">Delete</button>
                                                        </form>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.widget-user-image -->
                                    <a href="http://localhost/Plantillas/digidocu-1.0.4/public/admin/documents/1"
                                        style="color: black;">
                                        {{-- <span style="max-lines: 1; white-space: nowrap;margin-left: 3px;">
                                            <small class="label"
                                                style="background-color: #000000;font-size: 0.93rem;">Test</small>
                                        </span> --}}
                                        <h5 class="widget-user-username" title="" data-toggle="tooltip"
                                            data-original-title="Carpeta">{{ $modulo->NombreModulo }}</h5>
                                        <h5 class="widget-user-desc" style="font-size: 12px"><span data-toggle="tooltip"
                                                title=""
                                                data-original-title="12/06/2024 02:08 AM">{{ $modulo->created_at }}</span>
                                            {{-- <span class="pull-right" style="margin-right: 15px;">
                                                <i title="" data-toggle="tooltip" class="fa fa-remove"
                                                    style="color: #f44336;" data-original-title="Unverified"></i>
                                            </span> --}}
                                        </h5>
                                    </a>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </div>
@endsection
