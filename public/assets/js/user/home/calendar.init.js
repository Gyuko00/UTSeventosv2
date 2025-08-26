// calendar.init.js
import { state, setMonthYear, fetchEventsFromWindow, groupEvents } from "./calendar.core.js";
import { renderAll } from "./calendar.ui.js";
import { renderDayList } from "./calendar.daylist.js";
import { updateDayButtons } from "./calendar.ui.js";

function onDayClick(date, btn) {
  btn.style.transform = "scale(0.95)";
  setTimeout(() => { btn.style.transform = ""; }, 100);

  state.selectedDate = new Date(date);
  renderDayList(date);
  updateDayButtons();
}

function bindNav() {
  const $ = (s) => document.querySelector(s);
  $("#cal-prev")?.addEventListener("click", () => {
    setMonthYear(new Date(state.year, state.month - 1, 1));
    renderAll(onDayClick);
  });
  $("#cal-next")?.addEventListener("click", () => {
    setMonthYear(new Date(state.year, state.month + 1, 1));
    renderAll(onDayClick);
  });
  $("#cal-today")?.addEventListener("click", () => {
    const d = new Date();
    setMonthYear(d);
    renderAll(onDayClick);
    renderDayList(d);
  });
}

document.addEventListener("DOMContentLoaded", async () => {
  setMonthYear(new Date());
  bindNav();

  const events = await fetchEventsFromWindow();
  state.events = events;
  state.eventsByDate = groupEvents(events);

  renderAll(onDayClick);
  renderDayList(state.today);
});
