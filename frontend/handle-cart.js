const up = document.querySelectorAll(".cart_quantity_up");
const down = document.querySelectorAll(".cart_quantity_down");
const del = document.querySelectorAll(".cart_quantity_delete");

const UpdateSubTotal = () => {
	const cartTotal = document.querySelectorAll(".cart_total_price");

	let subTotal = 0;
	Object.values(cartTotal).map((item) => {
		subTotal += parseInt(item.textContent.replace("$", ""));
	});

	document.getElementById("Sub-Total").textContent = "$" + subTotal;
};
UpdateSubTotal();

Object.values(up).map((item) => {
	item.addEventListener("click", () => {
		HandleQuantity(item, 0);
	});
});
Object.values(down).map((item) => {
	item.addEventListener("click", () => {
		HandleQuantity(item, 1);
	});
});

Object.values(del).map((item) => {
	item.addEventListener("click", async () => {
		let id = item
			.closest("tr")
			.querySelector(".cart_description")
			.querySelector("p").textContent;
		item.closest("tr").innerHTML = "";
		const response = await fetch("ajax-delete-product-cart.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({ id }),
		});
		UpdateSubTotal();
	});
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
	UpdateSubTotal();
};
