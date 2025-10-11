// Aluno: Lucas Athanasio
// RA: 25002731

SET SERVEROUTPUT ON;
DECLARE
    vSalarioBruto NUMBER := 4500; // valor fixado do salário bruto
    vINSS NUMBER := 0.0;
    vIRRF NUMBER := 0.0;
    vSalarioLiquido NUMBER := 0.0;
BEGIN
    // Cálculo do INSS (contribuição 2024)
    IF vSalarioBruto <= 1412.00 THEN
        vINSS := vSalarioBruto * 0.075;
    ELSIF vSalarioBruto <= 2666.68 THEN
        vINSS := (1412.00 * 0.075) + ((vSalarioBruto - 1412.00) * 0.09);
    ELSIF vSalarioBruto <= 4000.03 THEN
        vINSS := (1412.00 * 0.075) + ((2666.68 - 1412.00) * 0.09) + ((vSalarioBruto - 2666.68) * 0.12);
    ELSIF vSalarioBruto <= 7786.02 THEN
        vINSS := (1412.00 * 0.075) + ((2666.68 - 1412.00) * 0.09) + ((4000.03 - 2666.68) * 0.12) + ((vSalarioBruto - 4000.03) * 0.14);
    ELSE
        vINSS := (1412.00 * 0.075) + ((2666.68 - 1412.00) * 0.09) + ((4000.03 - 2666.68) * 0.12) + ((7786.02 - 4000.03) * 0.14);
    END IF;

    // Base de cálculo do IRRF
    DECLARE
        vBaseIRRF NUMBER;
    BEGIN
        vBaseIRRF := vSalarioBruto - vINSS;

        // Cálculo do IRRF
        IF vBaseIRRF <= 2112.00 THEN
            vIRRF := 0;
        ELSIF vBaseIRRF <= 2826.65 THEN
            vIRRF := (vBaseIRRF * 0.075) - 158.40;
        ELSIF vBaseIRRF <= 3751.05 THEN
            vIRRF := (vBaseIRRF * 0.15) - 370.40;
        ELSIF vBaseIRRF <= 4664.68 THEN
            vIRRF := (vBaseIRRF * 0.225) - 651.73;
        ELSE
            vIRRF := (vBaseIRRF * 0.275) - 884.96;
        END IF;

        // Evita IRRF negativo
        IF vIRRF < 0 THEN
            vIRRF := 0;
        END IF;

        // Cálculo do Salário Líquido
        vSalarioLiquido := vSalarioBruto - vINSS - vIRRF;

        // Exibição dos resultados
        DBMS_OUTPUT.put_line('=== Cálculo de Salário ===');
        DBMS_OUTPUT.put_line('Salário Bruto : R$ ' || TO_CHAR(vSalarioBruto, '9999.99'));
        DBMS_OUTPUT.put_line('Desconto INSS : R$ ' || TO_CHAR(vINSS, '9999.99'));
        DBMS_OUTPUT.put_line('Desconto IRRF : R$ ' || TO_CHAR(vIRRF, '9999.99'));
        DBMS_OUTPUT.put_line('Salário Líquido : R$ ' || TO_CHAR(vSalarioLiquido, '9999.99'));
    END;
END;
