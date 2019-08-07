/**
 * Created by k.diakonidze on 7/29/19.
 */
$("i.fas").on("click", function (s) {
    var ddiv = this.closest("div");
    var iid = ddiv.id;
    console.log(iid);
})

function showDetails(animal) {
    console.log(animal);
    console.log( $('#form1').serialize() );
//    var animalType = animal.getAttribute("data-animal-type");
//    alert("The " + animal.innerHTML + " is a " + animalType + ".");
}