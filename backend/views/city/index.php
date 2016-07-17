<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cities';
$this->params['breadcrumbs'][] = $this->title;
?>


<p><a id="new" href="">Add new row</a></p>

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
                <td><a class="edit" href="">Edit</a></td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
                <td><a class="edit" href="">Edit</a></td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
                <td><a class="edit" href="">Edit</a></td>
            </tr>
            
        </tbody>
    </table>
<script type="text/ecmascript" src="/js/my/jquery.min.js"></script>
<script type="text/javascript" src="js/my/editor.js"></script>
<script>

$(document).ready(function() {
    var editor; 
    editor = new $.fn.dataTable.Editor( {
        ajax: "../php/staff.php",
        table: "#example",
        display: 'envelope',
        fields: [ {
                label: "Name:",
                name: "name"
            }, {
                label: "Position:",
                name: "position"
            }, {
                label: "Office:",
                name: "office"
            }, {
                label: "age:",
                name: "age"
            }, {
                label: "Start date:",
                name: "start_date"
            }, {
                label: "Salary:",
                name: "salary"
            }
        ]
    } );

    // New record
    $('a.editor_create').on( 'click', function (e) {
        e.preventDefault();
 
        editor
            .title( 'Create new record' )
            .buttons( { "label": "Add", "fn": function () { editor.submit() } } )
            .create();
    } );
 
    // Edit record
    $('#example').on( 'click', 'a.editor_edit', function (e) {
        e.preventDefault();
 
        editor
            .title( 'Edit record' )
            .buttons( { "label": "Update", "fn": function () { editor.submit() } } )
            .edit( $(this).closest('tr') );
    } );
 
    // Delete a record
    $('#example').on( 'click', 'a.editor_remove', function (e) {
        e.preventDefault();
 
        editor
            .title( 'Edit record' )
            .message( "Are you sure you wish to delete this row?" )
            .buttons( { "label": "Delete", "fn": function () { editor.submit() } } )
            .remove( $(this).closest('tr') );
    } );

    $('#example').DataTable();
     var oTable = $('#example').dataTable();
});




</script>

     