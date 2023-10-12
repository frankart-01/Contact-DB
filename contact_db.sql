CREATE TABLE `contact_db` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20)
);

INSERT INTO contact_db (first_name, last_name, email, phone) VALUES
('John', 'Doe', 'johndoe@example.com', '123-456-7890'),
('Jane', 'Smith', 'janesmith@example.com', '555-123-4567'),
('Mike', 'Johnson', 'mike@example.com', '987-654-3210'),
('Sara', 'Williams', 'sara@example.com', '333-444-5555'),
('Tom', 'Brown', 'tom@example.com', '777-888-9999'),
('Alice', 'Lee', 'alice@example.com', '111-222-3333'),
('Robert', 'Davis', 'robert@example.com', '999-888-7777'),
('Linda', 'Harris', 'linda@example.com', '222-333-4444'),
('Chris', 'Martin', 'chris@example.com', '555-777-9999'),
('Emily', 'Taylor', 'emily@example.com', '123-789-4567'),
('David', 'Clark', 'david@example.com', '555-555-5555'),
('Mary', 'Moore', 'mary@example.com', '666-666-6666'),
('Daniel', 'Anderson', 'daniel@example.com', '444-444-4444'),
('Laura', 'White', 'laura@example.com', '111-999-6666'),
('William', 'Wilson', 'william@example.com', '999-111-9999');
