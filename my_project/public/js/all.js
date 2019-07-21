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
    $.get("/books/add_to_favourite/" + bookId, {}, function (result) {
        if (result.status === "success") {
            alert("Добавиили");
        } else {
            alert("Все плохо!");
        }
    });
}


function liveSearch() {
    let q = $("#live-search").val();
    let $searchResult = $(".searchResult");
    if (q.length < 4) {
        $searchResult.html("");
        return;
    }
    $.get("/search", {q: q}, function (res) {

        if (res.length === 0) {
            $searchResult.html("Нет книг с таким названием!");
        } else {
            $searchResult.html("");
            let n = res.length;
            for (let i = 0; i < n; i++) {
                $searchResult.html($searchResult.html() + res[i]['title'] + "<br>");
            }
        }
    });
}
