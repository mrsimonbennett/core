@extends('dashboard.layout.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-l">
                <h2>Your Properties</h2>

                <p><a href="/properties/create" class="btn btn-primary btn-xs">Add Property</a>

                </p>
                <table class="table table-striped">

                    <tbody>
                    @foreach($properties as $property)
                        <tr>
                            <td>
                                <img src="http://placehold.it/200x100" alt="">
                            </td>
                            <td style="vertical-align:middle">
                                {{$property->address_firstline}} <br>{{$property->address_city}}
                                <br>{{$property->address_postcode}}
                            </td>
                            <td class="visible-lg" style="vertical-align:middle">
                                Contracts : 0
                            </td>
                            <td style="vertical-align:middle">
                                <a href="/properties/{{$property->id}}" class="btn btn-sm btn-primary">Manage</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop