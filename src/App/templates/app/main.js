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
});
