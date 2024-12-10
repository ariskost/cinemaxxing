document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("searchInput");
    const moviesList = document.getElementById("moviesList");

    searchForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form from refreshing the page
        const query = searchInput.value.trim();

        // Fetch movies from the server using BASE_PATH
        fetch(`${BASE_PATH}search_movies_api.php?query=${encodeURIComponent(query)}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Failed to fetch movies");
                }
                return response.json();
            })
            .then((movies) => {
                // Clear the existing movie list
                moviesList.innerHTML = "";

                // Check if movies are found
                if (movies.length === 0) {
                    moviesList.innerHTML = `<p class="text-center">No movies found</p>`;
                    return;
                }

                // Populate the movie list
                movies.forEach((movie) => {
                    const movieRow = document.createElement("div");
                    movieRow.className = "row mb-3 align-items-center";

                    movieRow.innerHTML = `
                        <div class="col-3">
                            <img src="assets/img/movies/${movie.img_poster}" alt="${movie.name}" class="img-fluid">
                        </div>
                        <div class="col-9">
                            <h5>${movie.name}</h5>
                        </div>
                    `;

                    moviesList.appendChild(movieRow);
                });
            })
            .catch((error) => {
                console.error("Error:", error);
                moviesList.innerHTML = `<p class="text-center text-danger">An error occurred. Please try again later.</p>`;
            });
    });
});
