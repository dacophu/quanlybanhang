const up = document.querySelector(".cart_quantity_up");
const down = document.querySelector(".cart_quantity_down");
const del = document.querySelector(".cart_quantity_delete");

up.addEventListener("click", () => {
	HandleQuantity(up, 0);
});

down.addEventListener("click", () => {
	HandleQuantity(down, 1);
});

del.addEventListener("click", async () => {
	console.log(this);
	let id = del
		.closest("tr")
		.querySelector(".cart_description")
		.querySelector("p").textContent;
	del.closest("tr").innerHTML = "";
	const response = await fetch("ajax-delete-product-cart.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({ id }),
	});

	const data = await response.json();
	console.log(data);
});

const HandleQuantity = async (e, type) => {
	let id = e
		.closest("tr")
		.querySelector(".cart_description")
		.querySelector("p").textContent;
	let qtyE = e.closest("div").querySelector(".cart_quantity_input");
	switch (type) {
		case 0:
			qtyE.value++;
			break;
		case 1:
			if (qtyE.value <= 1) {
				alert("Không được xóa product cuối cùng");
			} else {
				qtyE.value--;
			}
	}

	let qty = parseInt(qtyE.value);

	let price = e
		.closest("tr")
		.querySelector(".cart_price")
		.querySelector("p").textContent;
	price = parseInt(price.replace("$", ""));

	e.closest("tr").querySelector(".cart_total_price").textContent =
		"$" + qty * price;

	const response = await fetch("ajax-handle-qty-cart.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({ id, qty }),
	});

	const data = await response.json();

	console.log(data);
};
