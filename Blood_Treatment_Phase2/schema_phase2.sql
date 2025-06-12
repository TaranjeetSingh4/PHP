
-- New table for Phase 2
CREATE TABLE IF NOT EXISTS blood_tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    result ENUM('positive', 'negative') NOT NULL,
    consent_form VARCHAR(255),
    blood_center_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (blood_center_id) REFERENCES users(id)
);
