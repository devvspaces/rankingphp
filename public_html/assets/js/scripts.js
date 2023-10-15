$("document").ready(function () {
  function touchHandler(event) {
    var touch = event.changedTouches[0];

    var simulatedEvent = document.createEvent("MouseEvent");
    simulatedEvent.initMouseEvent(
      {
        touchstart: "mousedown",
        touchmove: "mousemove",
        touchend: "mouseup",
      }[event.type],
      true,
      true,
      window,
      1,
      touch.screenX,
      touch.screenY,
      touch.clientX,
      touch.clientY,
      false,
      false,
      false,
      false,
      0,
      null
    );

    touch.target.dispatchEvent(simulatedEvent);
    event.preventDefault();
  }

  function init() {
    let board = document.getElementById("board");
    board.addEventListener("touchstart", touchHandler, true);
    board.addEventListener("touchmove", touchHandler, true);
    board.addEventListener("touchend", touchHandler, true);
    board.addEventListener("touchcancel", touchHandler, true);
  }

  function editBoard() {
    let board = document.getElementById("board");
    elClone = board.cloneNode(true);
    board.parentNode.replaceChild(elClone, board);
  }

  init();

  $("#toggleEdit").click(function (event) {
    if ($(this).hasClass("btn-outline-primary")) {
      $(this).removeClass("btn-outline-primary");
      $(this).addClass("btn-success");
      editBoard();
    } else {
      $(this).addClass("btn-outline-primary");
      $(this).removeClass("btn-success");
      location.reload();
    }
  });

  // Function to update rank card count and icon
  function updateRankCount(rankCard, count, action = "UP") {
    action = action.toUpperCase();

    count = Math.abs(count);

    let rankCount = rankCard.querySelector(".rank-count");

    if (action == "UP") {
      if (rankCount.classList.contains("moveup")) {
        let currentCount = rankCount.innerText;
        count = parseInt(currentCount) + count;
      }
      rankCount.innerHTML =
        "<span><i class='fas fa-arrow-up'></i></span><p>" + count + "</p>";
      rankCount.className = "rank-count moveup";
    } else if (action == "DOWN") {
      if (rankCount.classList.contains("movedown")) {
        let currentCount = rankCount.innerText;
        count = parseInt(currentCount) + count;
      }
      rankCount.innerHTML =
        "<span><i class='fas fa-arrow-down'></i></span><p>" + count + "</p>";
      rankCount.className = "rank-count movedown";
    }
  }

  // Function to update rank card highest and lowest
  function updateHighAndLow(rankCard, newParentNum) {
    let highestSpan = rankCard.querySelector(".highest");
    let highestVal = parseInt(highestSpan.innerText);
    let lowestSpan = rankCard.querySelector(".lowest");
    let lowestVal = parseInt(lowestSpan.innerText);

    if (Number.isNaN(highestVal)) {
      highestSpan.innerText = newParentNum;
    } else if (newParentNum < highestVal) {
      highestSpan.innerText = newParentNum;
    }

    if (Number.isNaN(lowestVal)) {
      lowestSpan.innerText = newParentNum;
    } else if (newParentNum > lowestVal) {
      lowestSpan.innerText = newParentNum;
    }
  }

  $(".rank-card").draggable({
    revert: true,
  });

  function moveCard(newRankCard, newParent) {
    let oldParent = newRankCard.parentElement;

    let start = parseInt(oldParent.getAttribute("num"));
    let end = parseInt(newParent.getAttribute("num"));

    let movement = start - end;

    let counter = start;

    if (movement > 0) {
      for (let index = movement; index > 0; index--) {
        counter--;
        // Get the element to move
        let el = document.querySelector(".rank-parent[num='" + counter + "']");

        let rnkCard = el.firstElementChild;
        el.removeChild(rnkCard);

        // Move down
        el.nextElementSibling.appendChild(rnkCard);

        // Update el
        updateRankCount(rnkCard, 1, (action = "down"));

        // Update highest and lowest
        updateHighAndLow(rnkCard, counter + 1);
      }

      // Update the movement count for the new rankcard
      updateRankCount(newRankCard, movement);
      updateHighAndLow(newRankCard, end);
    } else if (movement < 0) {
      for (let index = movement; index < 0; index++) {
        counter++;
        // Get the element to move
        let el = document.querySelector(".rank-parent[num='" + counter + "']");

        let rnkCard = el.firstElementChild;
        el.removeChild(rnkCard);

        // Move up
        el.previousElementSibling.appendChild(rnkCard);

        // Update el
        updateRankCount(rnkCard, 1);

        // Update highest and lowest
        updateHighAndLow(rnkCard, counter - 1);
      }

      // Update the movement count for the new rankcard
      updateRankCount(newRankCard, movement, (action = "down"));
      updateHighAndLow(newRankCard, end);
    }

    newParent.appendChild(newRankCard);
    setCrowns();
  }

  $(".rank-parent").droppable({
    accept: ".rank-card",
    drop: function (event, ui) {
      let newRankCard = ui.draggable[0];
      let newParent = this;
      moveCard(newRankCard, newParent);
    },
  });

  if ($("#updateOrder").length) {
    $("#updateOrder").click(function (e) {
      let board = document.getElementById("board");

      // Get the children
      let children = Array.from(board.children);

      let objArr = [];

      for (let index = 0; index < children.length; index++) {
        let parent = children[index];

        // position, count, id, movement
        let position = parent.getAttribute("num");

        let rankCount = parent.querySelector(".rank-count");
        let highest = parent.querySelector(".highest").innerText;
        let lowest = parent.querySelector(".lowest").innerText;

        let count = rankCount.textContent;
        let movement = 0;
        if (rankCount.classList.contains("moveup")) {
          movement = 1;
        }

        let rankCard = parent.querySelector(".rank-card");
        let id = rankCard.getAttribute("rankID");

        let rankObj = {
          position: position,
          count: count,
          movement: movement,
          id: id,
          highest: highest,
          lowest: lowest,
        };

        objArr.push(rankObj);
      }

      // Converting obj arr into json
      var jsonString = JSON.stringify(objArr);

      // Send with ajax
      $.ajax({
        type: "POST",
        url: "/ranks/updateOrder/",
        data: { jsonString: jsonString },
        cache: false,
        success: function (data) {
          alert("Ranks order successfully updated");
        },
        error: function (xhr, status, error) {
          console.error(xhr);
        },
      });
    });
  }
});
