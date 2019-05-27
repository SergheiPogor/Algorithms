<script>
function echoHello(){
 alert("<?PHP hello(); ?>");
 }
</script>

<?PHP

function hello(){
    echo "Call php function on onclick event.";
}

?>

<button onclick="echoHello()">Say Hello</button>