// SHA-256 hashing utility with salt and iterations
async function hashPasswordSHA256(password, salt = null) {
    // Generate salt if not provided
    if (!salt) {
        const array = new Uint8Array(16);
        crypto.getRandomValues(array);
        salt = Array.from(array, byte => byte.toString(16).padStart(2, '0')).join('');
    }
    
    // Combine password with salt
    let hash = password + salt;
    
    // Hash 10,000 times (key stretching for security)
    for (let i = 0; i < 10000; i++) {
        const encoder = new TextEncoder();
        const data = encoder.encode(hash);
        const hashBuffer = await crypto.subtle.digest('SHA-256', data);
        hash = Array.from(new Uint8Array(hashBuffer))
            .map(b => b.toString(16).padStart(2, '0'))
            .join('');
    }
    
    return { salt, hash };
}

async function verifyPasswordSHA256(password, storedSalt, storedHash) {
    const { hash } = await hashPasswordSHA256(password, storedSalt);
    return hash === storedHash;
}

export { hashPasswordSHA256, verifyPasswordSHA256 };