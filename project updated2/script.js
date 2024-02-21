const booksSection = document.getElementById('books');
fetch('books.php')
.then(response => response.json())
.then(books => {
  books.forEach(book => {
    const bookDiv = document.createElement('div');
    bookDiv.classList.add('book');
    bookDiv.innerHTML = `
      <h2>${book.Title}</h2>
      <p>Genre: ${book.GenreName}</p>
      <p>Publisher: ${book.PublisherName}</p>
      <p>Author: ${book.AuthorName}</p>
    `;
    booksSection.appendChild(bookDiv);
  });
});