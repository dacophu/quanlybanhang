const allBtn = document.querySelectorAll(".add-to-cart");

Object.values(allBtn).map((item) => {
	item.addEventListener("click", async (e) => {
		e.preventDefault();
		let id = item.getAttribute("id");

		const response = await fetch("ajax-cart.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({ id }),
		});

		const data = await response.json();

		console.log(data);
	});
});
