<?php 
	require_once __DIR__ .'/../../../config/Config.php';

?>

<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
		<div class="relative p-4 w-full max-w-md max-h-full">
			<!-- Modal content -->
			<div class="relative bg-white rounded-lg shadow">
				<!-- Modal header -->
				<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
					<h3 class="text-lg font-semibold text-green-700" id="modal-title">
						
					</h3>
					<button type="button" class="text-green-700 bg-transparent hover:bg-gray-200 hover:text-green-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" onclick="closeModal()">
						<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
						</svg>
						<span class="sr-only">Close modal</span>
					</button>
				</div>
				<!-- Modal body -->
				<form class="p-4 md:p-5" id="formProduto" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id" id="id" value="">
					<div class="grid gap-4 mb-4 grid-cols-2">
						<div class="col-span-2">
							
							<div class="flex items-center justify-center w-full" id="input-imagem">
								<label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-green-700 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
									<div class="flex flex-col items-center justify-center pt-5 pb-6">
										<svg class="w-12 h-12 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
											<path fill-rule="evenodd" d="M7.5 4.586A2 2 0 0 1 8.914 4h6.172a2 2 0 0 1 1.414.586L17.914 6H19a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1.086L7.5 4.586ZM10 12a2 2 0 1 1 4 0 2 2 0 0 1-4 0Zm2-4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" clip-rule="evenodd"/>
										</svg>

										<p class="mb-2 text-sm text-green-700"><span class="font-semibold">Click para selecionar</span> arraste e solte aqui a imagem</p>
										<p class="text-xs text-green-700">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
									</div>
									<input onchange="previewFile()" id="dropzone-file" name="imagem" type="file" class="hidden" accept="image/*" />
								</label>
							</div> 

							<div id="preview" class="hidden text-center">
								<img id="img-preview" src="#" alt="preview" class="w-64 mx-auto"/>
								<button type="button" onclick="removeFile()" class="mt-4 text-white inline-flex items-center bg-gradient-to-l from-teal-300 to-teal-500 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
									<span class="text-white">Remover imagem</span>
								</button>
							</div>

						</div>
						<div class="col-span-2">
							<label for="nome" class="block mb-2 text-sm font-medium text-green-700">Nome</label>
							<input type="text" name="nome" id="nome" class="bg-gray-50 border border-gray-300 text-green-700 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5" placeholder="Mouse gamer" required="">
						</div>
						<div class="col-span-2 sm:col-span-1">
							<label for="preco" class="block mb-2 text-sm font-medium text-green-700">Preço</label>
							<input type="text" name="preco" id="preco" class="bg-gray-50 border border-gray-300 text-green-700 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5" placeholder="R$ 149,90" required="">
						</div>
						<div class="col-span-2 sm:col-span-1">
							<label for="estoque" class="block mb-2 text-sm font-medium text-green-700">Estoque</label>
							<input type="number" name="estoque" id="estoque" class="bg-gray-50 border border-gray-300 text-green-700 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5" placeholder="20" required="">
						</div>
					</div>
					<button type="button" onclick="saveProduto()" id="btn-produto" class="text-white inline-flex items-center bg-gradient-to-l from-teal-300 to-teal-500 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
						
					</button>
				</form>
			</div>
		</div>
	</div> 