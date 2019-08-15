function calcul(ress)
{
   switch(ress)
   {
      case 'metal':
         var Crystal   = $("#crystal").val();
         var Deuterium = $("#deuterium").val();
         var Norio = $("#norio").val();

         var Metal = Crystal * res_a + Deuterium * res_b + Norio * res_d;

         if (isNaN(Metal)) {
            $("#metal").text("Numero Nulo");
         }
         else
            $("#metal").text(NumberGetHumanReadable(Metal));
      break;
      case 'crystal':
         var Metal   = $("#metal").val();
         var Deuterium = $("#deuterium").val();
         var Norio = $("#norio").val();

         var Crystal = Metal * res_a + Deuterium * res_b + Norio * res_d;

         if (isNaN(Crystal))
            $("#crystal").text("Numero Nulo");
         else
            $("#crystal").text(NumberGetHumanReadable(Crystal));
      break;
      case 'deuterium':
         var Metal   = $("#metal").val();
         var Cristal = $("#crystal").val();
         var Norio   = $("#norio").val();

         var Deuterium = Metal * res_a + Cristal * res_b + Norio * res_d;

         if (isNaN(Deuterium))
            $("#deuterium").text("Numero Nulo");
         else
            $("#deuterium").text(NumberGetHumanReadable(Deuterium));
      break;
      case 'norio':
         var Metal   = $("#metal").val();
         var Cristal = $("#crystal").val();
         var Deuterium = $("#deuterium").val();

         var Norio = Metal * res_a + Cristal * res_b + Deuterium * res_c;

         if (isNaN(Norio))
            $("#norio").text("Numero Nulo");
         else
            $("#norio").text(NumberGetHumanReadable(Norio));;
      break;
   }
}