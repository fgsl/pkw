/**
 * PHP Kubectl Web console
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @license https://www.gnu.org/licenses/lgpl-3.0.en.html
 */
$(document).ready(function(){
//namespace	
    $("button.namespace_button").click(function(){
        $( "div#general-result p#paragraph-result code" ).html("Wait...");
        $.post( "namespace", $("form#form-namespace").serialize() ,function( data ) {
            $( "div#general-result p#paragraph-result code" ).html( data.output );
        },"json");        
    });
    $("input#namespace-annotations").click(function(){
        $("input#namespace-labels").prop("checked", false);       
    });
    $("input#namespace-labels").click(function(){
        $("input#namespace-annotations").prop("checked", false);       
    });
//resource quota    
    $("button.resourcequota_button").click(function(){
    	$( "div#general-result p#paragraph-result code" ).html("Wait...");
        $.post( "resourcequota", $("form#form-resourcequota").serialize() ,function( data ) {
            $( "div#general-result p#paragraph-result code" ).html( data.output );
        },"json");        
    });
//pods
    $("button.pods_button").click(function(){
    	$( "div#general-result p#paragraph-result code" ).html("Wait...");
        $.post( "pods", $("form#form-pods").serialize() ,function( data ) {
            $( "div#general-result p#paragraph-result code" ).html( data.output );
        },"json");
    });
    $("input#pods-object").click(function(){
        $("input#pods-labels").prop("checked", false);       
    });
    $("input#pods-labels").click(function(){
        $("input#pods-object").prop("checked", false);       
    });
// clear button    
    $("button.clear_result_button").click(function(){
        $( "div#general-result p#paragraph-result code" ).html( "" );       
    });    
  //create-pod
    $("button.create_pod_button").click(function(){
    	$( "div#general-result p#paragraph-result code" ).html("Wait...");
    	var fd = new FormData();
    	var files = $("input#yaml")[0].files[0];
    	fd.append("yaml",files);
    	
        $.ajax({
        	url: "pod",
        	type: "post",
        	data: fd,
        	contentType: false,
        	processData: false,
        	success: function( data ) {
        		$( "div#general-result p#paragraph-result code" ).html( data.output );
        	},
        	error: function () {
        		$( "div#general-result p#paragraph-result code" ).html("An error occurred" );
        	}
        });
    });
    //delete-pod
    $("button.delete_pod_button").click(function(){
    	$( "div#general-result p#paragraph-result code" ).html("Wait...");
        $.ajax({
        	url: "pod",
        	type: "post",
        	data: $("form#form-delete-pod").serialize(),
        	success: function( data ) {
        		$( "div#general-result p#paragraph-result code" ).html( data.output );
        	},
        	error: function () {
        		$( "div#general-result p#paragraph-result code" ).html("An error occurred" );
        	}
        });
    });    
});
