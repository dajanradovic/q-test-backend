
let deleteButtons = document.getElementsByClassName('delete-button');
for (var i = 0; i < deleteButtons.length; i++) {
    deleteButtons[i].addEventListener('click', (e) =>{
        e.preventDefault();
        const form = e.currentTarget;
        const authorId = form.dataset.id
        const url = document.getElementById('authorsTable').dataset.baseurl;
        fetch(url + '/api/author/books', {
            method: 'post',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({author_id : authorId})
          }).then(res => res.json())
            .then((res) =>{
                if(!res.message){
                    let answer = confirm("Are you sure");
                        if (answer == true) {
                            form.submit();
                        } 
                }
                else{
                    alert('you cannot delete this author');
                }
              
                
            });
        })
}