function showBook(bookId) {
    $.get("/books/" + bookId + ".json", {}, function (book) {
        showModal(
            "Просмотр кники №" + bookId,
            book.title + "; Цена: " + book.price,
            "<div class=\"btn btn-primary\">Купить</div>"
        );
    });
}

function showModal(title, content, buttons) {
    $(".container").addClass("blur");
    $("#modalBackgroud").show();

    let modalWrapper = $("#bookModalTemplate")
        .html()
        .replace('{title}', title)
        .replace('{content}', content)
        .replace('{buttons}', buttons)
    ;

    $("#modalBackgroud").after(modalWrapper);
}

function hideModal() {
    $("#modalBackgroud").hide();
    $("#modalBackgroud").next().remove();
    $(".blur").removeClass("blur");
}

function addToFavourite(bookId) {
    $.get("/books/add_to_favourite/" + bookId, {}, function(result) {
        if(result.status === "success") {
            alert("Добавиили");
        } else {
            alert("Все плохо!");
        }
    });
}
