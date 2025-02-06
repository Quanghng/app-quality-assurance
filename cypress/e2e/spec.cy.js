describe('Gestion des utilisateurs', () => {
    const baseUrl = 'http://localhost/gestion_produit/';
    const userName = 'Toto';
    const userEmail = 'toto1234@example.com';
    const userAge = 25;
    const updatedName = 'Toto2';
    const updatedEmail = 'toto5678@example.com';
    const updatedAge = 30;

    beforeEach(() => {
        cy.visit(baseUrl);
    });

    it('Ajoute un utilisateur et vérifie son affichage', () => {
        cy.get('#name').type(userName);
        cy.get('#email').type(userEmail);
        cy.get('#age').type(userAge)
        cy.get('form').submit();
        
        cy.contains(userName).should('be.visible');
        cy.contains(userEmail).should('be.visible');
        cy.contains(userAge).should('be.visible');
    });

    it('Modifie les informations de l’utilisateur', () => {
        cy.contains(userName).parent().within(() => {
            cy.get('button').contains('✏️').click();
        });
        
        cy.get('#name').clear().type(updatedName);
        cy.get('#email').clear().type(updatedEmail);
        cy.get('#age').clear().type(updatedAge);
        cy.get('form').submit();

        cy.contains(updatedName).should('be.visible');
        cy.contains(updatedEmail).should('be.visible');
        cy.contains(updatedAge).should('be.visible');
    });

    it('Supprime l’utilisateur et vérifie sa disparition', () => {
        cy.contains(updatedName).parent().within(() => {
            cy.get('button').contains('❌').click();
        });
        
        cy.contains(updatedName).should('not.exist');
        cy.contains(updatedEmail).should('not.exist');
        cy.contains(updatedAge).should('not.exist');
    });
});
