/**
 * Indonesian translation
 *  @name Indonesian
 *  @anchor Indonesian
 *  @author Cipto Hadi
 */

var indonesianLang = {
	sEmptyTable: "Tidak ada data yang tersedia pada tabel ini",
	sProcessing: "Sedang memproses...",
	sLengthMenu: "Tampilkan _MENU_ entri",
	sZeroRecords: "Tidak ditemukan data yang sesuai",
	sInfo: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
	sInfoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
	sInfoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
	sInfoPostFix: "",
	sSearch: "Cari:",
	sUrl: "",
	oPaginate: {
		sFirst: "Pertama",
		sPrevious: "Sebelumnya",
		sNext: "Selanjutnya",
		sLast: "Terakhir",
	},
}

function formatRupiah(angka, prefix) {
	if (typeof angka !== "string") {
		if (angka) {
			angka = angka.toString()
		} else {
			angka = "0"
		}
	}

	var number_string = angka.replace(/[^,\d]/g, "").toString()
	var split = number_string.split(",")
	var sisa = split[0].length % 3
	var rupiah = split[0].substr(0, sisa)
	var ribuan = split[0].substr(sisa).match(/\d{3}/gi)

	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if (ribuan) {
		separator = sisa ? "." : ""
		rupiah += separator + ribuan.join(".")
	}

	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah
	return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : ""
}

function rupiah_to_integer(rupiah) {
	var angka = rupiah.replace("Rp. ", "")
	if (angka.includes(".")) {
		angka = angka.replace(".", "")
	}

	return typeof parseInt(angka) == "number" ? parseInt(angka) : 0
}

function setupDatatable(params) {
	// Setup datatables
	$.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
		return {
			iStart: oSettings._iDisplayStart,
			iEnd: oSettings.fnDisplayEnd(),
			iLength: oSettings._iDisplayLength,
			iTotal: oSettings.fnRecordsTotal(),
			iFilteredTotal: oSettings.fnRecordsDisplay(),
			iPage: Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
			iTotalPages: Math.ceil(
				oSettings.fnRecordsDisplay() / oSettings._iDisplayLength
			),
		}
	}

	var paramDatatables = {
		initComplete: function () {
			var api = this.api()
			$("#table_filter input")
				.off(".DT")
				.on("input.DT", function () {
					api.search(this.value).draw()
				})
		},
		oLanguage: indonesianLang,
		processing: true,
		serverSide: true,
		searching: params.searching ?? true,
		ajax: {
			url: params.url,
			type: "POST",
			data: function (data) {
				data.searchDate = params.date
				data.custom_search = params.search
			},
		},
		columns: params.columns,
		order: [[1, "asc"]],
		rowCallback: function (row, data, iDisplayIndex) {
			var info = this.fnPagingInfo()
			var index = iDisplayIndex + 1
			var page = info.iPage
			var length = info.iLength
			if (params.custom_columns) {
				params.custom_columns.forEach(function (item) {
					if (item.val == "index") {
						$(`td:eq(${item.index})`, row).html(index + page * length)
					} else {
						$(`td:eq(${item.index})`, row).html(item.val)
					}
				})
				return row
			}
		},
		drawCallback: function (settings) {
			var info = this.fnPagingInfo()
			var total = info.iTotal
			var length = info.iLength

			if (total > length) {
				$(".dataTables_paginate").show()
			} else {
				$(".dataTables_paginate").hide()
			}
		},
	}

	if (params.createdRow) {
		paramDatatables.createdRow = params.createdRow
	}

	var table = $("#table").DataTable(paramDatatables)
	// end setup datatables

	return table
}

function setupSwal(args = null) {
	return Swal({
		title: args.title,
		text: args.text,
		type: args.type,
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: args.confirmText,
	})
}

function show_sweet_alert(param) {
	var sweetAlertParam = {
		title: param.title,
		type: param.type,
		showConfirmButton: param.showConfirmButton ? true : false,
		showCancelButton: param.showCancelButton ? true : false,
		timer: param.timer ? param.timer : 2000,
		confirmButtonText: "Ya",
		cancelButtonText: "Tidak",
	}

	if (param.text) {
		sweetAlertParam.text = param.text
	}

	if (param.html) {
		sweetAlertParam.html = param.html
	}

	return Swal.fire(sweetAlertParam).then(function (result) {
		if (param.redirect) {
			window.location = param.redirect
		}

		return result
	})
}

// select2
$(".select2").select2()

function openModal(modalName) {
	$("#" + modalName).modal({ backdrop: "static", keyboard: false })
}

function clearInputText(...inputIds) {
	inputIds.forEach((inputId) => {
		var inputContainer = $("#" + inputId)
			.parent()
			.parent()
		var helpBlock = $("#" + inputId).next()
		$("#" + inputId).val("")

		if (inputContainer.hasClass("has-error")) {
			inputContainer.removeClass("has-error")
			helpBlock.hide()
		}
	})
}

function clearInputSelect(...inputIds) {
	inputIds.forEach((inputId) => {
		$("#" + inputId)
			.parent()
			.parent()
			.removeClass("has-error")
		$("#" + inputId)
			.next()
			.next()
			.hide()
		$("#" + inputId)
			.next()
			.css("border", "")
		$("#" + inputId)
			.val(null)
			.trigger("change")
	})
}

function errorInputText(inputId, message) {
	$("#" + inputId)
		.parent()
		.parent()
		.addClass("has-error")

	var nextElement = $(`#${inputId}`).next('.help-block')

	if (nextElement.length == 0) {
		$("#" + inputId).after(`<span class='help-block'>${message}</span>`)
	} else {
		nextElement.show()
		nextElement.text(message)
	}
}

function errorInputSelect(inputId, message) {
	$("#" + inputId)
		.parent()
		.parent()
		.addClass("has-error")

	$("#" + inputId)
		.next()
		.next()
		.text(message)

	$("#" + inputId)
		.next()
		.css("border", "0.5px solid red")

	$("#" + inputId)
		.next()
		.next()
		.show()

	var nextElement = $(`#${inputId}`).next().next('.help-block')

	if (nextElement.length == 0) {
		$("#" + inputId).next().after(`<span class='help-block'>${message}</span>`)
	} else {
		nextElement.show()
		nextElement.text(message)
	}
}