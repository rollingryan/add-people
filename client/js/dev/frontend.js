const peopleElements = document.querySelectorAll("ap__item");
console.log("peopleElements", peopleElements);

const peopleArray = Array.prototype.slice.call(peopleElements);
console.log("peopleArray", peopleArray);

// peopleElements.map((person) => {
//   console.log("person", person);

//   person.onClick((event) => {
//     console.log("event", event);
//   });
// });
