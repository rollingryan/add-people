const peopleItems = document.getElementsByClassName("ap__item");

peopleItems.map((person) => {
  console.log("person", person);

  person.onClick((event) => {
    console.log("event", event);
  });
});
