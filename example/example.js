// Loop through vote buttons
var buttons = document.getElementsByClassName("btn");
for(var i = 0; i < buttons.length; i++) {
  // Store button
  var button = buttons[i];
  // On click
  button.addEventListener("click", updatePoll);
}

// Update poll results
function updatePoll(event) {
  // Get index and vote count
  var index = parseInt(event.target.value),
  percentageCells = document.getElementsByClassName("percentage"),
  voteCells = document.getElementsByClassName("votes"),
  voteCell = voteCells[index],
  voteCount = parseInt(voteCell.textContent);
  // Increment vote count
  voteCount++;
  voteCell.textContent = voteCount;
  // Get total vote count
  var votes = [];
  for(var i = 0; i < voteCells.length; i++) {
    votes.push(parseInt(voteCells[i].textContent));
  }
  // Recalculate percentages
  var percentages = new Percentages(votes).corrected;
  // Update percentages in table
  for(var i = 0; i < percentageCells.length; i++) {
    percentageCells[i].textContent = percentages[i] + "%";
  }
}
