
    <div id="customerTableView">
        <table class="display" id="wordTable" style="width:100%; border: 1px solid; border-collapse: collapse;">
            <div class="table responsive">
                <thead>
                <tr>
                    <th>Word</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Winning Plays</th>
                    <th>Total Plays</th>
                    <th>Clue</th>
                    <th>Modify</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <div>
                    <strong> Toggle column: </strong> 
                    <a id="toggle" class="toggle-vis" data-column="0">Word</a> - 
                    <a id="toggle" class="toggle-vis" data-column="1">Date</a> - 
                    <a id="toggle" class="toggle-vis" data-column="2">Time</a> - 
                    <a id="toggle" class="toggle-vis" data-column="3">Winning Plays</a> - 
                    <a id="toggle" class="toggle-vis" data-column="4">Total Plays</a> - 
                    <a id="toggle" class="toggle-vis" data-column="5">Clue</a> - 
                    <a id="toggle" class="toggle-vis" data-column="6">Modify</a> - 
                    <a id="toggle" class="toggle-vis" data-column="7">Delete</a> -
                </div> <br>
                
                <?php
                $conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
                $sql = "SELECT * FROM puzzle_words";
                $result = $conn->query($sql);

                // fetch the data from $_GLOBALS
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                    $word = $row["word"];
                    $date = $row["date"];
                    $time = $row["time"];
                    $winning_plays = $row["winning_plays"];
                    $total_plays = $row["total_plays"];
                    $clue = $row['clue'];

                ?>
                <tr>
                    <td><?php echo $word; ?></td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'date','<?php echo $word; ?>')"><?php echo $date; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'time','<?php echo $word; ?>')"><?php echo $time; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'winning_plays','<?php echo $word; ?>')"><?php echo $winning_plays ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'total_plays','<?php echo $word; ?>')"><?php echo $total_plays; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'clue','<?php echo $word; ?>')"><?php echo $clue; ?></div></span> </td>
                    <?php echo '<td><a class="btn btn-warning btn-sm" href="update_word.php?id='.$row["word"].'">Modify</a></td>' ?>
                    <?php echo '<td><a class="btn btn-danger btn-sm" href="delete.php?rn='.$row["word"].'">Delete</a></td>' ?>
                </tr>
                 <?php  //end while
                }//end if
            }//end second if 

            $conn -> close();
                ?>

                </tbody>
            </div>
        </table>
    </div>
</div>

<!-- /.container -->

<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 

<script type="text/javascript" charset="utf8"
        src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<!--Data Table-->
<script type="text/javascript" charset="utf8"
        src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script type="text/javascript" language="javascript">
    $(document).ready( function () {
        
        $('#wordTable').DataTable( {
            dom: 'lfrtBip',
            buttons: [
                'copy', 'excel', 'csv', 'pdf'
            ] }
        );

        $('#wordTable thead tr').clone(true).appendTo( '#wordTable thead' );
        $('#wordTable thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    
        var table = $('#wordTable').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            retrieve: true
        } );
        
    } );

    $(document).ready(function() {
        
    var table = $('#wordTable').DataTable( {
        retrieve: true,
        "scrollY": "200px",
        "paging": false
    } );
 
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
} );


function updateValue(element,column,id){
        var value = element.innerText
        $.ajax({
            url:'editable_list.php',
            type: 'post',
            data:{
                value: value,
                column: column,
                id: id
            },
            success:function(php_result){
				console.log(php_result);
				
            }
            
        })
    }




</script>