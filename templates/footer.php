<!-- Load jQuery Validator
<script src="js/jquery.validate.min.js"></script>
<script src="js/additional-methods.min.js"></script>
<script src="js/jquery.tablesorter.min.js"></script>  -->


<script>
    // $("#form_input").validate();

    $(document).ready(function () {

        $(".button-collapse").sideNav();

        $('select').material_select();

        $('input').css('visibility', 'visible');
    });


    $('.question').slice(1).hide();
    $('#next, a.mcqtest').click(function () {
        //code
        var curr = $(".question:visible");
        var next = curr.next(".question");
        next.show();
        curr.hide();
        if (!next.next(".question").length) {
            $("button").prop('disabled', true);
            $("button").text("End of Test");
        }
    });
</script>

<script type "text/javascript">
    function save(id,id2,id3,id4) {
        //var id = $("#AncharID").attr("data-myid");  // getting from attr
        //alert(id);
        $.ajax({
            url: "../../config/functions.php",
            data: {
                answer: id,
                question: id2,
                test: id3,
                user: id4
            },
            dataType: 'JSON',
            type: 'POST',
            cache: false,
            success: function (response) {
                if (response.status == 1) {
                    //alert('success');
                    console.log('success');
                } else {
                    //alert('failure');
                    console.log('failure');
                }
            },
            error: function (response) {
               // console.log(response);
            }
        });
    }
</script>

<footer>version 0.6</footer>

</body>

</html>