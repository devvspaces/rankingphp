$("document").ready(function () {
  let board = document.getElementById("board");

  function editBoard() {
    elClone = board.cloneNode(true);
    board.parentNode.replaceChild(elClone, board);
  }

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

        let rnkCard = el.querySelector(".rank-card");
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

        let rnkCard = el.querySelector(".rank-card");
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

  // On long press of rank card set class to selected
  let rankCards = Array.from(document.getElementsByClassName("rank-card"));
  let selectedRankCard = null;

  function stopSelectionMode() {
    board.classList.remove("active");
    selectedRankCard.parentElement.classList.remove("selected");
    selectedRankCard = null;
  }

  rankCards.forEach((el, idx) => {
    el.addEventListener("long-press", function (e) {
      if (!selectedRankCard) {
        el.parentElement.classList.add("selected");
        selectedRankCard = el;
        board.classList.add("active");
      }
    });

    let move = el.parentElement.querySelector(".move");

    move.addEventListener("click", function (e) {
      if (selectedRankCard) {
        if (el == selectedRankCard) {
          stopSelectionMode();
        } else {
          selectedRankCard.parentElement.classList.remove("selected");
          moveCard(selectedRankCard, el.parentElement);
          stopSelectionMode();
        }
      }
    });
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
          position: parseInt(position),
          count: parseInt(count) || 0,
          movement: movement,
          id: id,
          highest: parseInt(highest) || 0,
          lowest: parseInt(lowest) || 0,
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
