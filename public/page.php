<html>
<head>
    <title>page</title>
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>

</head>
<body>
<form>
    <label for="">sum</label><br />
    <input type="number" id="sum" /><br />
    <label for="">type</label><br />
    <select id="type">
        <option value="income">приход</option>
        <option value="outcome">расход</option>
    </select><br />
    <label for="">comment</label><br />
    <textarea id="comment" cols="30" rows="10"></textarea><br />
    <button id="btn_add">add</button><br />
</form>
<div id="table-container" style="width:350px;"></div>

<script>
    $('document').ready(function() {
        getAll();
        $('#btn_add').on('click', function(evt) {
            evt.preventDefault();
            addItem();
        });
        $('#table-container').on('click', '.btn-del', function (evt) {
            evt.preventDefault();
            var id = $(this).attr("data-id");
            delItem(id);
        });
    });
    function getAll() {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "ajax.php",
            data: {},
            success: function(response){
                $('#table-container').empty();
                var htmlOut = "<table style='width:100%;'><tr><th>type</th><th>comment</th><th>sum</th></tr>";
                if (response.data.length > 0) {
                    $.each(response['data'], function(index, item) {
                        htmlOut += `<tr>
                            <td>${item['type']}</td>
                            <td>${item['comment']}</td>
                            <td>${item['sum']}</td>
                            <td><button class="btn-del" data-id="${item['id']}">del</button></td>
                        </tr>`;
                    });
                }
                htmlOut += `<TR><td colspan='2'>total</td><td>${response['sum_total']}</td></TR>`;
                htmlOut += "</table>";
                $('#table-container').html(htmlOut);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error("some error", XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }
    function addItem() {
        var sum = $('#sum').val();
        var type = $('#type').val();
        var comment = $('#comment').val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "ajax.php",
            data: {
                'action': 'create',
                'sum': sum,
                'type': type,
                'comment': comment
            },
            success: function(response){
                getAll();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error("some error", XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }
    function delItem(id) {
        console.error("delItem");
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "ajax.php",
            data: {
                'action': 'delete',
                'id': id
            },
            success: function(response){
                getAll();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.error("some error", XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }
</script>
</body>
</html>

<?php
