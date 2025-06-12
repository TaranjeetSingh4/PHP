$(function () {
    checkNumeric();

    debugger;

    $(".close").click(function () {
        $("#divMsg").fadeOut('slow');
    });

    $("#btnSave").click(function () {
        $("#divMsg").fadeIn('slow');
    });
});


function checkNumeric() {
    var specialKeys = new Array();
    specialKeys.push(8); //Backspace
    specialKeys.push(9);
    specialKeys.push(46);
    $(".numeric").bind("keypress", function (e) {
        var keyCode = e.which ? e.which : e.keyCode
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        $(".error").css("display", ret ? "none" : "inline");
        return ret;
    });
}

function getPropertyStatus(PropertyCategory) {
    $("#PropertyStatus > option").show();
    if ($(PropertyCategory).val() != "") {
        $("#PropertyStatus option[value!=" + $(PropertyCategory).val() + "]").hide();
        $("#PropertyStatus option[value='']").show();
        $("#PropertyStatus").val($("#PropertyStatus option:first").val());

        fnAreaDeclaration($(PropertyCategory).val(), $("#PropertyStatus").val(), $("#PropertyType").val());
    }
    else {
        $("#PropertyStatus").val($("#PropertyStatus option:first").val());
    }

    if ($(PropertyCategory).val() == "R") {
        $("#tr_ResidentialDiscount").show();
        $("#tr_RentedCharges").hide();

        $("#Caption_discOrInc").text("Discount");
    }
    else if ($(PropertyCategory).val() == "C") {
        $("#tr_ResidentialDiscount").hide();
        $("#tr_RentedCharges").show();

        $("#Caption_discOrInc").text("Increase");
    }

    $('input[name="rbl_AgeOfConstruction"]').prop('checked', false);
    $("#txtTotalRebateAmount").val("");
}

function fnSelectArea(ddlWard) {
    $("#ddlArea > option").show();
    if ($(ddlWard).val() != "") {
        $("#ddlArea option[value!=" + $(ddlWard).val() + "]").hide();
        $("#ddlArea option[value='']").show();
        $("#ddlArea").val($("#ddlArea option:first").val());
    }
    else {
        $("#ddlArea").val($("#ddlArea option:first").val());
    }
}

function changePropertyStatus(PropertyStatus) {
    fnAreaDeclaration($("#PropertyCategory").val(), $(PropertyStatus).val(), $("#PropertyType").val());
}

function getPropertyType(PropertyType) {
    if ($(PropertyType).val() != "") {
        $("#div_ProvideLocationDetails").show();
        if ($(PropertyType).val() == "BH" || $(PropertyType).val() == "BOL") {
            $("#div_LocationDetail_A").show();
            $("#div_LocationDetail_B").show();
        }
        else if ($(PropertyType).val() == "OL") {
            $("#div_LocationDetail_A").show();
            $("#div_LocationDetail_B").hide();
        }

        fnAreaDeclaration($("#PropertyCategory").val(), $("#PropertyStatus").val(), $(PropertyType).val());
    }
    else {
        $("#div_ProvideLocationDetails").hide();
    }
}

function fnAreaDeclaration(PropertyCategory, PropertyStatus, PropertyType) {
    var PropertyStatus_Combo = new Boolean(false);
    if ($("#PropertyStatus option:selected").text().indexOf('+') > -1) {
        PropertyStatus_Combo = true;
    }
    $("#Caption_selfOccupied").text("Building / House Area Declaration");
        
    if (PropertyCategory == "R" && PropertyStatus == "R" && !PropertyStatus_Combo.valueOf()
        && (PropertyType == "BH" || PropertyType == "OL" || PropertyType == "BOL")) { // Residential + Self Residential + Property Type

        $("#div_SelfOccupiedAreaDec").show();

        $("#div_RentedAreaDec").hide();
        fnClear_Rented_Area();

        if (PropertyType == "OL" || PropertyType == "BOL") {
            $("#div_OpenLandAreaDec").show();
            if (PropertyType == "OL") {
                $("#div_SelfOccupiedAreaDec").hide();
                fnClear_Self_Occupied_Area();
            }
        }
        else {
            $("#div_OpenLandAreaDec").hide();
            fnClear_Open_Land_Area();
        }
    }
    else if (PropertyCategory == "C" && PropertyStatus == "C" && !PropertyStatus_Combo.valueOf()
        && (PropertyType == "BH" || PropertyType == "OL" || PropertyType == "BOL")) {   //  Commercial + Rented Property + Property Type

        $("#div_SelfOccupiedAreaDec").hide();
        fnClear_Self_Occupied_Area();

        $("#div_RentedAreaDec").show();

        if (PropertyType == "OL" || PropertyType == "BOL") {
            $("#div_OpenLandAreaDec").show();
            if (PropertyType == "OL") {
                $("#div_SelfOccupiedAreaDec").hide();
                fnClear_Self_Occupied_Area();

                $("#div_RentedAreaDec").hide();
                fnClear_Rented_Area();
            }
        }
        else {
            $("#div_OpenLandAreaDec").hide();
            fnClear_Open_Land_Area();
        }
    }
    else if (PropertyCategory == "C" && PropertyStatus == "C" && PropertyStatus_Combo
        && (PropertyType == "BH" || PropertyType == "OL" || PropertyType == "BOL")) {    // Commercial + (Self Residential + Rented Property) + Property Type

        $("#div_SelfOccupiedAreaDec").show();
        $("#div_RentedAreaDec").show();

        if (PropertyType == "OL" || PropertyType == "BOL") {
            $("#div_OpenLandAreaDec").show();
            if (PropertyType == "OL") {
                $("#div_SelfOccupiedAreaDec").hide();
                fnClear_Self_Occupied_Area();

                $("#div_RentedAreaDec").hide();
                fnClear_Rented_Area();
            }
        }
        else {
            $("#div_OpenLandAreaDec").hide();
            fnClear_Open_Land_Area();
        }
        $("#Caption_selfOccupied").text("Self Occupied Area Declaration");
    }
    fnCalc_TotalTax();
    fnChangeCaption();
}

function fnClear_Self_Occupied_Area() {
    $("#txt_area_of_all_room_Self_Occupied").val("");
    $("#txt_area_for_Balcony_Self_Occupied").val("");
    $("#txt_area_of_Garage_Self_Occupied").val("");
    $("#txt_Total_area_Self_Occupied").val("");
    $("#txt_rate_Self_Occupied").val("");
    $("#txt_Total_Monthly_tax_Self_Occupied").val("");
    $("#txt_Total_Annual_Tax_Self_Occupied").val("");
}

function fnClear_Rented_Area() {
    $("#txt_area_of_all_room_Rented").val("");
    $("#txt_area_for_Balcony_Rented").val("");
    $("#txt_area_of_Garage_Rented").val("");
    $("#txt_Total_area_Rented").val("");
    $("#txt_rate_Rented").val("");
    $("#txt_Total_Monthly_tax_Rented").val("");
    $("#txt_Total_Annual_Tax_Rented").val("");
}

function fnClear_Open_Land_Area() {
    $("#txt_Open_land_area").val("");
    $("#txt_Open_land_rate").val("");
    $("#txt_Open_land_monthly_tax").val("");
    $("#txt_Open_land_annual_tax").val("");
}

function fnCalculate_Self_Occupied_Total_Area() {
    var area_of_all_room_Self_Occupied, area_for_Balcony_Self_Occupied, area_of_Garage_Self_Occupied;

    if ($("#txt_area_of_all_room_Self_Occupied").val() != "") {
        area_of_all_room_Self_Occupied = parseInt($("#txt_area_of_all_room_Self_Occupied").val());
    }
    else {
        area_of_all_room_Self_Occupied = 0;
    }

    if ($("#txt_area_for_Balcony_Self_Occupied").val() != "") {
        area_for_Balcony_Self_Occupied = parseInt($("#txt_area_for_Balcony_Self_Occupied").val());
    }
    else {
        area_for_Balcony_Self_Occupied = 0;
    }

    if ($("#txt_area_of_Garage_Self_Occupied").val() != "") {
        area_of_Garage_Self_Occupied = parseInt($("#txt_area_of_Garage_Self_Occupied").val());
    }
    else {
        area_of_Garage_Self_Occupied = 0;
    }

    $("#txt_Total_area_Self_Occupied").val(area_of_all_room_Self_Occupied + (area_for_Balcony_Self_Occupied / 2) + (area_of_Garage_Self_Occupied / 4));
}

function fnCal_ApplicableRate_Self_Occupied() {
    if ($("#txt_rate_Self_Occupied").val() != "" && $("#txt_Total_area_Self_Occupied").val() != "") {
        $("#txt_Total_Monthly_tax_Self_Occupied").val(($("#txt_rate_Self_Occupied").val() * $("#txt_Total_area_Self_Occupied").val()).toFixed(2));

        $("#txt_Total_Annual_Tax_Self_Occupied").val((($("#txt_rate_Self_Occupied").val() * $("#txt_Total_area_Self_Occupied").val()) * 12).toFixed(2));

        fnCalc_TotalTax();
    }
}

function fnCalculate_Rented_Total_Area() {
    var area_of_all_room_Rented, area_for_Balcony_Rented, area_of_Garage_Rented;

    if ($("#txt_area_of_all_room_Rented").val() != "") {
        area_of_all_room_Rented = parseInt($("#txt_area_of_all_room_Rented").val());
    }
    else {
        area_of_all_room_Rented = 0;
    }

    if ($("#txt_area_for_Balcony_Rented").val() != "") {
        area_for_Balcony_Rented = parseInt($("#txt_area_for_Balcony_Rented").val());
    }
    else {
        area_for_Balcony_Rented = 0;
    }

    if ($("#txt_area_of_Garage_Rented").val() != "") {
        area_of_Garage_Rented = parseInt($("#txt_area_of_Garage_Rented").val());
    }
    else {
        area_of_Garage_Rented = 0;
    }

    $("#txt_Total_area_Rented").val(area_of_all_room_Rented + (area_for_Balcony_Rented / 2) + (area_of_Garage_Rented / 4));
}

function fnCal_ApplicableRate_Rented() {
    if ($("#txt_rate_Rented").val() != "" && $("#txt_Total_area_Rented").val() != "") {
        $("#txt_Total_Monthly_tax_Rented").val(($("#txt_rate_Rented").val() * $("#txt_Total_area_Rented").val()).toFixed(2));

        $("#txt_Total_Annual_Tax_Rented").val((($("#txt_rate_Rented").val() * $("#txt_Total_area_Rented").val()) * 12).toFixed(2));

        fnCalc_TotalTax();
    }
}

function fnCal_Open_Land_Area() {
    if ($("#txt_Open_land_area").val() != "" && $("#txt_Open_land_rate").val() != "") {
        $("#txt_Open_land_monthly_tax").val(($("#txt_Open_land_area").val() * $("#txt_Open_land_rate").val()).toFixed(2));

        $("#txt_Open_land_annual_tax").val((($("#txt_Open_land_area").val() * $("#txt_Open_land_rate").val()) * 12).toFixed(2));

        fnCalc_TotalTax();
    }
}

function fnCalc_TotalTax() {

    var Total_Annual_Tax_Self_Occupied, Total_Annual_Tax_Rented, Total_Open_land_annual_tax;
    if ($("#txt_Total_Annual_Tax_Self_Occupied").val() != "") {
        Total_Annual_Tax_Self_Occupied = parseFloat($("#txt_Total_Annual_Tax_Self_Occupied").val());
    }
    else {
        Total_Annual_Tax_Self_Occupied = 0;
    }

    if ($("#txt_Total_Annual_Tax_Rented").val() != "") {
        Total_Annual_Tax_Rented = parseFloat($("#txt_Total_Annual_Tax_Rented").val());
    }
    else {
        Total_Annual_Tax_Rented = 0;
    }

    if ($("#txt_Open_land_annual_tax").val() != "") {
        Total_Open_land_annual_tax = parseFloat($("#txt_Open_land_annual_tax").val());
    }
    else {
        Total_Open_land_annual_tax = 0;
    }

    $("#txtAll_Annual_Tax").val((Total_Annual_Tax_Self_Occupied + Total_Annual_Tax_Rented + Total_Open_land_annual_tax).toFixed(2));

    if ($("#txtAll_Annual_Tax").val() != "") {
        $("#txtTotal_Chargable_Tax").val((($("#txtAll_Annual_Tax").val() * 10) / 100).toFixed(2));
        $("#txtTotalRebateAmount").val($("#txtTotal_Chargable_Tax").val());
    }

    $("#txtDiscount").val("");
    $("#txtDiscountOnAnnualValue").val("");
}

function fnChangeAgeOfConstruction(rbl_AgeOfConstruction) {
    var range = $(rbl_AgeOfConstruction).val();
    var taxableAmount = 0, discountAmount = 0, discountPercentage = 0, paybleAmount = 0, symbol = "";    

    taxableAmount = parseFloat($("#txtTotalRebateAmount").val());

    if ($("#PropertyCategory").val() == "R") {
        symbol = "(-) ";
        debugger;

        $("#hdnResiDisc_1_10").closest('td').removeClass();
        $("#hdnResiDisc_10_20").closest('td').removeClass();
        $("#hdnResiDisc_20_Over").closest('td').removeClass();
        if (range == 1) {
            discountPercentage = parseFloat($("#hdnResiDisc_1_10").val());
            $("#hdnResiDisc_1_10").closest('td').addClass('highlight');
        }
        else if (range == 2) {
            discountPercentage = parseFloat($("#hdnResiDisc_10_20").val());
            $("#hdnResiDisc_10_20").closest('td').addClass('highlight');
        }
        else if (range == 3) {
            discountPercentage = parseFloat($("#hdnResiDisc_20_Over").val());
            $("#hdnResiDisc_20_Over").closest('td').addClass('highlight');
        }        

        discountAmount = (taxableAmount * discountPercentage) / 100;
        paybleAmount = taxableAmount - discountAmount;
    }
    else if ($("#PropertyCategory").val() == "C") {
        symbol = "(+) ";

        $("#hdnRentCharge_1_10").closest('td').removeClass();
        $("#hdnRentCharge_10_20").closest('td').removeClass();
        $("#hdnRentCharge_20_Over").closest('td').removeClass();
        if (range == 1) {
            discountPercentage = parseFloat($("#hdnRentCharge_1_10").val());
            $("#hdnRentCharge_1_10").closest('td').addClass('highlight');
        }
        else if (range == 2) {
            discountPercentage = parseFloat($("#hdnRentCharge_10_20").val());
            $("#hdnRentCharge_10_20").closest('td').addClass('highlight');
        }
        else if (range == 3) {
            discountPercentage = 0;
            $("#hdnRentCharge_20_Over").closest('td').addClass('highlight');
        }

        if (discountPercentage == 0) {
            symbol = "";
        }

        discountAmount = (taxableAmount * discountPercentage) / 100;
        paybleAmount = taxableAmount + discountAmount;
    }

    if (discountAmount > 0 || paybleAmount > 0) {
        $("#txtDiscount").val(symbol + discountAmount.toFixed(2));
        $("#txtDiscountOnAnnualValue").val(paybleAmount.toFixed(2));
    }
    else {
        $("#txtDiscount").val("0");
        $("#txtDiscountOnAnnualValue").val("0");
    }

}

function fnChangeCaption() {
    if ($("#PropertyType").val() == "BH") {
        $("#caption_LocatedOn").text("A. Building / House is located  : - ");
    }
    else if ($("#PropertyType").val() == "OL") {
        $("#caption_LocatedOn").text("A. Open Land is located  : -");
    }
    else if ($("#PropertyType").val() == "BOL") {
        $("#caption_LocatedOn").text("A. Building / House with Open Land is located  : -");
    }
    else {
        $("#caption_LocatedOn").text("A. Land and building is located  : -");
    }

    var self, rented, OpenLand;

    if ($("#div_SelfOccupiedAreaDec").is(':visible')) {
        self = $("#Caption_selfOccupied").text();
        self = self.replace("Declaration", "").trim() + " + ";
    }
    else { self = ""; }

    if ($("#div_RentedAreaDec").is(':visible')) {
        rented = $("#Caption_RentedArea").text();
        rented = " + " + rented.replace("Declaration", "").trim() + " + ";
    }
    else { rented = ""; }

    if ($("#div_OpenLandAreaDec").is(':visible')) {
        OpenLand = $("#Caption_OpenLand").text();
        OpenLand = " + " + OpenLand.replace("Declaration", "").trim();
    }
    else { OpenLand = ""; }

    var finalcaption = (self + rented + OpenLand).replace("+  +", "+").replace("+  +", "+").trim();
    if (finalcaption.indexOf("+") == 0) {
        finalcaption = finalcaption.substring(1, finalcaption.length);
    }

    if (finalcaption.lastIndexOf("+") == finalcaption.length - 1) {
        finalcaption = finalcaption.substring(0, finalcaption.lastIndexOf("+"));
    }

    $("#Caption_CalOfTax").text(finalcaption.trim());
}