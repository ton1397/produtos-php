

const modal = document.getElementById('crud-modal');
// options with default values
const options = {
	placement: 'bottom-right',
	backdrop: 'dynamic',
	backdropClasses:
		'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
	closable: true,
	onHide: () => {
		console.log('modal is hidden');
		document.querySelector('#formProduto').reset();
		document.querySelector('#formProduto #preview').classList.add('hidden');
		document.querySelector('#formProduto #input-imagem').classList.remove('hidden');
		document.querySelector('#formProduto #img-preview').src = '';
		document.querySelector('#formProduto #id').value = '';
		
	},
	onShow: () => {
		if(document.querySelector('#formProduto #id').value != ''){
			document.querySelector('#formProduto #btn-produto').innerHTML = `
				<svg class="me-1 -ms-1 w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
					<path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
					<path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
				</svg>
				Atualizar
			`

			document.querySelector('#modal-title').innerHTML = 'Atualizar Produto';
			document.querySelector('#formProduto #input-imagem input').value = '';

		} else {
			document.querySelector('#formProduto #btn-produto').innerHTML = `
				<svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
				Criar Produto
			`

			document.querySelector('#modal-title').innerHTML = 'Criar Novo Produto';

		}
	},
};

// instance options object
const instanceOptions = {
id: 'modalEl',
override: true
};

const modalProduto = new window.Modal(modal, options, instanceOptions);



function openModal(produto_id=null) {

	if(produto_id){
		
		let tr = document.querySelector(`tr[data-id="${produto_id}"]`);
		let td = tr.querySelectorAll('td');

		let imagem = td[0].querySelector('img').src;
		let nome = td[1].textContent;
		let preco = td[2].textContent.replace('R$ ', '');
		let estoque = td[3].textContent;

		document.querySelector('#formProduto #img-preview').src = imagem;
		document.querySelector('#formProduto #preview').classList.remove('hidden');
		document.querySelector('#formProduto #input-imagem').classList.add('hidden');

		document.querySelector('#formProduto #id').value = produto_id;
		document.querySelector('#formProduto #nome').value = nome.trim();
		document.querySelector('#formProduto #preco').value = preco.trim();
		document.querySelector('#formProduto #estoque').value = estoque.trim();

	}

	console.log(document.querySelector('#formProduto #dropzone-file').value);

	modalProduto.show()
}

function closeModal() {

	modalProduto.hide()

}

function previewFile() {
	let file = document.querySelector('input[type=file]').files;
	
	if (file.length > 0) {
		document.querySelector('#preview img').src = URL.createObjectURL(file[0]);
		document.querySelector('#preview').classList.remove('hidden');
		document.querySelector('#input-imagem').classList.add('hidden');
	}
}

function removeFile() {
	document.querySelector('#preview').classList.add('hidden');
	document.querySelector('#input-imagem').classList.remove('hidden');

}

function saveProduto() {
	event.preventDefault();

	let form = document.querySelector('#formProduto');

	let formData = new FormData(form);

	formData.set('preco', parseFloat(parseFloat(formData.get('preco').replace(',', '.')).toFixed(2)));

	if(formData.get('imagem').name == '') {
		formData.delete('imagem');
	}

	let url = `${window.location.href}/src/Controller/AddProdutoController.php`;

	if(document.querySelector('#formProduto #id').value != ''){
		url = `${window.location.href}/src/Controller/UpdateProdutoController.php`;
	}

	$.ajax({
		url: url,
		method: "POST",
		data: formData,
		processData: false,
		contentType: false
	}).done(function(response) {
		console.log(response);
		Swal.fire({
			title: "Sucesso!",
			text: response.message,
			icon: "success",
			iconHtml: `
				<svg class="w-20 h-20 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
				</svg>
			`,
			customClass: {
				confirmButton: "bg-white text-teal-500 outline-none border-none",
				popup: "bg-green-500 text-white",
				icon: "text-white",
			}
		  }).finally(() => {
			closeModal();
			window.location.reload();
		})
	}).fail(function(textStatus, errorThrown) {
		console.log(textStatus, errorThrown);
		Swal.fire({
			title: "Error!",
			text: "Erro ao cadastrar o produto!",
			icon: "error",
			iconHtml: `
				<svg class="w-20 h-20 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
					<path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
				</svg>
			`,
			customClass: {
				confirmButton: "bg-white text-teal-500 outline-none border-none",
				popup: "bg-red-500 text-white",
				icon: "text-white",
			}
		});
	})
}

function deleteProduto(id) {
	Swal.fire({
		title: "Tem certeza?",
		text: "Deseja realmente excluir este produto?",
		icon: "warning",
		iconHtml: `
			<svg class="w-20 h-20 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
				<path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd"/>
			</svg>
		`,
		showCancelButton: true,
		confirmButtonText: "Sim, Deletar!",
		cancelButtonText: "Não, Cancelar!",
		customClass: {
			confirmButton: "bg-white text-teal-500 outline-none border-none",
			cancelButton: "bg-red-500 text-white outline-none border-none",
			popup: "bg-yellow-500 text-white",
			icon: "text-white",
		}
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: `${window.location.href}/src/Controller/DeleteProdutoController.php?id=${id}`,
				method: "POST",
				processData: false,
				contentType: false
			}).done(function(response) {
				Swal.fire({
					title: "Sucesso!",
					text: response.message,
					icon: "success",
					iconHtml: `
						<svg class="w-20 h-20 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
						</svg>
					`,
					customClass: {
						confirmButton: "bg-white text-teal-500 outline-none border-none",
						popup: "bg-green-500 text-white",
						icon: "text-white",
					}
				  }).finally(() => {
					window.location.reload();
				})
			}).fail(function(textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
				Swal.fire({
					title: "Erro!",
					text: "Erro ao deletar o produto!",
					icon: "error",
					iconHtml: `
						<svg class="w-20 h-20 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
							<path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
						</svg>
					`,
					customClass: {
						confirmButton: "bg-white text-teal-500 outline-none border-none",
						popup: "bg-red-500 text-white",
						icon: "text-white",
					}
				});
			})
				
		}
	})
}
