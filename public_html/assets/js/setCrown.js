
  
// Function to set the first three crowns
function setCrowns(){
    let board = document.getElementById('board');

    // Get the children
    let children = Array.from(board.children);

    // Initialise the crown maps
    let crowns = ['gold', 'silver', 'bronze']

    for (let index = 0; index < children.length; index++) {
    
    let parent = children[index];
    let rankTitle = parent.querySelector('.rank-title');

    if (index < 3){
        rankTitle.className='rank-title ' + crowns[index];
    } else {
        rankTitle.className='rank-title';
    }

    rankTitle.lastElementChild.innerHTML = "No. " + (index + 1);
    }
}

setCrowns()

let parentBox = document.querySelectorAll('.rank-parent');
function searchRankings(e){
    let input_val = e.target.value
    parentBox.forEach(i=>{
        let text = i.querySelector('h4').innerText
        if (text.indexOf(input_val) == -1){
            i.style.display = 'none';
        } else {
            i.style.display = 'block';
        }
    })
}


let formSearch = document.querySelector('.form-search');
if (formSearch != undefined){
    let input = document.querySelector('.form-search input')
    input.addEventListener('keyup', searchRankings)
}