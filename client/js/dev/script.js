import frontendStyles from "../../sass/_frontend.scss";
import adminStyles from "../../sass/_admin.scss";

const popupHandler = (element) => {
  element.addEventListener("click", () => {
    const parentElement = element.closest(".ap__item");
    const popup = parentElement.querySelector(".ap__popup");

    if (popup.classList.contains("ap__popup--visible")) {
      return popup.classList.remove("ap__popup--visible");
    }
    return popup.classList.add("ap__popup--visible");
  });
};

document.addEventListener("DOMContentLoaded", () => {
  const triggerElements = document.querySelectorAll(".ap__trigger");
  const triggerArray = Array.from(triggerElements);

  triggerArray.map((trigger) => {
    popupHandler(trigger);
  });
});
